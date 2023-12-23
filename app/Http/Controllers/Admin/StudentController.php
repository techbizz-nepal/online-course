<?php

namespace App\Http\Controllers\Admin;

use App\DTO\StudentData;
use App\Http\Controllers\Controller;
use App\Mail\StudentCreated;
use App\Models\Questionnaire\Exam;
use App\Models\Student;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query()
            ->when($request->get('query'), function (Builder $builder) use ($request) {
                $builder->where('name', 'like', "%{$request->get('query')}%")
                    ->orWhere('email', 'like', "%{$request->get('query')}%");
            })
            ->select(['id', 'first_name', 'surname', 'email', 'pdf'])
            ->withCount('exams')
            ->simplePaginate(5)
            ->appends($request->except('page'));

        $viewData = [
            'viewDetailUrl' => '',
            'students' => $students,
            'next_page_url' => $students->nextPageUrl(),
            'prev_page_url' => $students->previousPageUrl(),
        ];

        return view('admin.students.index', $viewData);
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function show(Student $student)
    {
        $notNeeded = ['id', 'title', 'first_name', 'surname', 'key', 'username', 'password', 'remember_token', 'pdf', 'display_order', 'status', 'extra', 'updated_at'];
        $onlyColumns = array_diff(Schema::getColumnListing('students'), $notNeeded) + ['fullName'];
        arsort($onlyColumns);
        $data['student'] = $student->only($onlyColumns);
        $data['survey'] = Arr::pull($data['student'], 'survey') ;
        return view('admin.students.show', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required | min: 1 | max: 250',
            'surname' => 'required | min: 1 | max: 250',
            'pdf' => 'required|mimes:pdf|max:10000',
            'email' => 'required|regex:/^.+@.+$/i',
        ]);
        DB::beginTransaction();
        try {
            $uniqueKey = generate_random_key();
            $key = Str::slug($data['first_name'].' '.$data['surname'].' '.$uniqueKey);

            $pdf = $request->file('pdf');
            $pdfName = $key.'.'.$pdf->extension();
            $pdf->move(storage_path(StudentData::SYSTEM_PATH), $pdfName);
            $data['key'] = $key;
            $data['pdf'] = sprintf('%s/%s', StudentData::PUBLIC_PATH, $pdfName);
            $data['username'] = $key;
            $data['password'] = bcrypt('student123');
            $newStudent = tap(Student::query()->create($data))->target;
            $newStudent->setAttribute('password', bcrypt(StudentData::DEFAULT_PASSWORD));
            Mail::to($newStudent->email)->send(new StudentCreated($newStudent));
            DB::commit();

            return redirect()->route('admin.student.index')->with('success', 'Student Created Successfully');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info('while adding student', [$exception->getMessage()]);

            return back()->withErrors('Failed to add student.');
        }
    }

    public function edit(Student $student): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => 'required | min: 1 | max: 250',
            'surname' => 'required | min: 1 | max: 250',
            'pdf' => 'file|nullable|mimetypes:application/pdf|max:10000',
            'email' => 'required|regex:/^.+@.+$/i',
        ]);
        DB::beginTransaction();
        try {
            $key = $student->getAttribute('key');
            if ($request->hasFile('pdf')) {
                $getSystemPath = Str::replace('storage', 'app/public', $student->getAttribute('pdf'));
                if (File::exists(storage_path($getSystemPath))) {
                    File::delete(storage_path($getSystemPath));
                }
                $pdf = $request->file('pdf');
                $pdfName = $key.'.'.$pdf->extension();
                $pdf->move(storage_path(StudentData::SYSTEM_PATH), $pdfName);
                $data['pdf'] = sprintf('%s/%s', StudentData::PUBLIC_PATH, $pdfName);
            }
            $student->update($data);
            DB::commit();

            return redirect()->route('admin.student.index')->with('success', 'Student Updated Successfully');
        } catch (Exception $exception) {
            DB::rollBack();

            return back()->withErrors('Failed to update student.');
        }
    }

    public function downloadQR(Student $student)
    {
        $url = asset($student->pdf);
        $headers = ['Content-Type' => ['svg']];
        $imageName = 'qr-code-'.uniqid().generate_random_key();
        $image = QrCode::format('svg')->size(200)->generate($url);

        Storage::disk('public')->put($imageName, $image);

        return response()->download('storage/'.$imageName, $imageName.'.svg', $headers)->deleteFileAfterSend();
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', 'Item Deleted Successfully');
    }

    public function exams(Student $student)
    {
        $student = $student->load(['exams' => function (HasMany $q) {
            $q->with([
                'module' => function ($q) {
                    $q->select(['id', 'name', 'fullMark', 'passMark']);
                },
            ])->with('examQuestion');
        }])
            ->only(['id', 'usi', 'fullName', 'email', 'exams']);
        $exams = Arr::pull($student, 'exams');

        foreach ($exams as $exam) {
            $score = $exam->pluckScore()->sum();
            $exam->score = $score;
            $exam->pass = false;
            if ($score >= $exam->module->passMark) {
                $exam->pass = true;
            }
        }
        $data = [
            'student' => $student,
            'exams' => $exams,
        ];

        return view('admin.students.results.index', $data);
    }

    public function result(Student $student, Exam $exam)
    {
        $data['exam'] = $exam->load(['examQuestion', 'module' => function ($q) {
            $q->select(['id', 'name']);
        }]);
        $data['student'] = $student->only(['fullName']);

        return view('admin.students.results.result', $data);
    }

    public function submitAnswerWeight(Request $request, string $id): JsonResponse
    {
        $data = $request->validate([
            'score' => ['numeric', 'required'],
        ]);

        $data = DB::table('questionnaire_exam_question')
            ->where('id', $id)
            ->update($data);

        return Response::json($data);
    }
}
