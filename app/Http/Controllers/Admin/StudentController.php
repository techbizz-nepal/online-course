<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create(){
        return view('admin.students.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required | min: 1 | max: 250',
            "pdf" => "required|mimes:pdf|max:10000"
        ]);
        DB::beginTransaction();
        try {
            $uniqueKey = generate_random_key();
            $key = Str::slug($data['name']." ".$uniqueKey);

            $pdf = $request->file('pdf');
            $pdfName = $key.'.'.$pdf->extension();
            $pdf->move(public_path('storage/files/students'), $pdfName);
            $data['key'] = $key ;
            $data['pdf'] = "storage/files/students/".$pdfName;
            Student::create($data);

            DB::commit();
            return redirect()->route('admin.student.index')->with('success', "Student Created Successfully");
        }catch (Exception $exception){
            DB::rollBack();
            return back()->withErrors("Failed to add student.");
        }
    }

    public function edit(Student $student){
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student){
        $data = $request->validate([
            'name' => 'required | min: 1 | max: 250',
        ]);
        DB::beginTransaction();
        try {
            $key = $student->key;
            if ($request->has('pdf')){
                $request->validate([
                    "pdf" => "mimes:pdf|max:10000"
                ]);
                unlink(public_path($student->pdf));
                $pdf = $request->file('pdf');
                $pdfName = $key.'.'.$pdf->extension();
                $pdf->move(public_path('storage/files/students'), $pdfName);
                $data['pdf'] = "storage/files/students/".$pdfName;
            }
            $student->update($data);
            DB::commit();
            return redirect()->route('admin.student.index')->with('success', "Student Updated Successfully");
        }catch (Exception $exception){
            DB::rollBack();
            return back()->withErrors("Failed to update student.");
        }
    }

    public function downloadQR(Student $student){
        $url = asset($student->pdf);
        $headers = array('Content-Type' => ['svg']);
        $imageName  = 'qr-code-'.uniqid().generate_random_key();
        $image = QrCode::format('svg')->size(200)->generate($url);

        Storage::disk("public")->put($imageName, $image);

        return response()->download('storage/'.$imageName, $imageName.'.svg', $headers)->deleteFileAfterSend();
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Item Deleted Successfully');
    }

}
