<?php

namespace App\Questionnaire;

use App\DTO\StudentData;
use App\Enums\Questionnaire\QuestionType;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class StudentFacade
{
    public function __construct(public array $surveyData = ['disabilities' => []])
    {
    }

    public function startExam(Module $module)
    {
        $createAttributes = [
            'module_id' => $module->id,
            'student_id' => Auth::guard('student')->id(),
        ];
        $queryAttributes = [
            ['module_id', '=', $module->id],
            ['student_id', '=', Auth::guard('student')->id()],
        ];

        $exam = Exam::query()->where($queryAttributes)->first();
        if ($exam === null) {
            $exam = Exam::query()->create($createAttributes);
        }

        return $exam;
    }

    public function populateAnsweredQuestions(Exam $exam): array
    {
        $list = [];
        Exam::query()
            ->with('examQuestion')
            ->where([
                ['student_id', '=', Auth::guard('student')->id()],
                ['id', '=', $exam->getAttribute('id')],
            ])
            ->get()
            ->each(function (Exam $exam) use (&$list) {
                foreach ($exam->examQuestion as $item) {
                    $row = [
                        'id' => $item->id,
                        'body' => $item->body,
                        'type' => $item->type->value(),
                    ];
                    if (in_array($item->type->value, QuestionType::getCorrectTypes()) && $item->pivot->is_correct) {
                        $row['status'] = 'correctly answered';
                        $row['action'] = null;
                    } else {
                        $row['status'] = 'incorrectly answered';
                        $row['action'] = 'retake';
                    }
                    if (in_array($item->type->value, QuestionType::getReviewTypes())) {
                        $row['status'] = 'answered';
                        $row['action'] = null;
                    }
                    $list[] = $row;
                }

                return $exam;
            });

        return $list;
    }

    public function populateQuestions(Module $module, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return Question::byModuleId($module->getAttribute('id'))
            ->select($columns)
            ->get();
    }

    public function getMappedQuestionsWithAnswers(Module $module, Exam $exam): Collection
    {
        $mapped = collect();
        $questions = $this->populateQuestions($module)->toArray();
        $answeredQuestions = collect($this->populateAnsweredQuestions($exam));

        array_walk($questions, function ($value, $key) use ($answeredQuestions, &$mapped) {
            if (in_array($value['id'], $answeredQuestions->pluck('id')->toArray())) {
                $answered = $answeredQuestions->firstWhere('id', $value['id']);
                $value['status'] = $answered['status'];
                $value['action'] = $answered['action'];
            } else {
                $value['status'] = 'new';
                $value['action'] = 'open';
            }
            $mapped[] = $value;
        });

        return $mapped;
    }

    public function getNextQuestion(Module $module, Question $question)
    {
        self::pullQuestionFromSession($module, $question);

        return collect(Session::get($module->slug))->first() ?? null;
    }

    public function startSession(Module $module, Collection $questionsOfModule): void
    {
        try {
            $filtered = self::filterQuestionForSession($questionsOfModule);
            Session::put($module->slug, $filtered);
        } catch (\Exception $exception) {
            Log::error('while storing questions: ', [$exception->getMessage()]);
        }
    }

    public function pullQuestionFromSession(Module $module, Question $question): void
    {
        try {
            $questions = Session::get($module->slug) ?? [];
            $filtered = Arr::where($questions, function ($row) use ($question) {
                return $row['id'] !== $question->id;
            });
            Session::put($module->slug, $filtered);
        } catch (\Exception $exception) {
            Log::error('while storing questions: ', [$exception->getMessage()]);
        }
    }

    private function filterQuestionForSession(Collection $questionOfModule): array
    {
        $filtered = $questionOfModule->whereIn('status', ['incorrectly answered', 'new']);

        return $filtered->all();
    }

    public function postUpdateProfile(StudentData $studentData, Authenticatable $student): RedirectResponse
    {
        try {
            $student->update($studentData->toArray());

            return redirect()->back()->with('success', 'Profile Updated.');
        } catch (\Exception $exception) {
            return back()->withErrors(['msg' => $exception->getMessage()])->withInput();
        }
    }

    public function getStudentWithFormInputs(Authenticatable $student): array
    {
        return [
            'student' => $student,
            'titleOptions' => [
                ['value' => 'mr', 'label' => 'Mr'],
                ['value' => 'mrs', 'label' => 'Mrs'],
                ['value' => 'dr', 'label' => 'Dr'],
            ],
            'genderOptions' => [
                ['value' => 'male', 'label' => 'Male'],
                ['value' => 'female', 'label' => 'Female'],
                ['value' => 'other', 'label' => 'Other'],
            ],
        ];
    }

    public function getEnquiryData(array $existingSurvey): array
    {
        $this->surveyData = $existingSurvey;

        return [
            'general' => [
                'title' => 'General',
                'queries' => [
                    [
                        'title' => 'Have you ever studied with Knowledge Empowers You before?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'general.studied_before.value', value: 'yes', label: 'Yes'),
                            $this->createSingleChoiceInput(key: 'general.studied_before.value', value: 'no', label: 'No'),
                            $this->createSingleChoiceInput(key: 'general.studied_before.label', value: 'Have you ever studied with Knowledge Empowers You before?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'Do you wish to apply for Credit?',
                        'subtitle' => 'If YES, certified copies of transcripts from previous qualifications must be provided with this form, along with a Credit Application Form.',
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'general.apply_credit.value', value: 'yes', label: 'Yes'),
                            $this->createSingleChoiceInput(key: 'general.apply_credit.value', value: 'no', label: 'No'),
                            $this->createSingleChoiceInput(key: 'general.apply_credit.value', value: 'maybe', label: 'Maybe I’d like more information'),
                            $this->createSingleChoiceInput(key: 'general.apply_credit.label', value: 'Do you wish to apply for Credit?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'Do you wish to apply for Recognition of Prior Learning?',
                        'subtitle' => 'If you indicate YES, you will be contacted to discuss this further.',
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'general.prior_learning.value', value: 'yes', label: 'Yes'),
                            $this->createSingleChoiceInput(key: 'general.prior_learning.value', value: 'no', label: 'No'),
                            $this->createSingleChoiceInput(key: 'general.prior_learning.value', value: 'maybe', label: 'Maybe I’d like more information'),
                            $this->createSingleChoiceInput(key: 'general.prior_learning.label', value: 'Do you wish to apply for Recognition of Prior Learning?', type: 'hidden'),
                        ],
                    ],
                ],
            ],
            'language_and_cultural_diversity' => [
                'title' => 'Language and cultural diversity',
                'queries' => [
                    [
                        'title' => 'In which country were you born?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.country_born.value', value: 'australia', label: 'Australia'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.country_born.value', value: 'other', label: 'Other'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.country_born_other.value', type: 'text'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.country_born.label', value: 'In which country were you born?', type: 'hidden'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.country_born_other.label', value: 'In which country were you born?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'Do you speak a language other than English at home?',
                        'subtitle' => 'If more than one language, indicate the one that is spoken most often.',
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speaking_language.value', value: 'only-english', label: 'No, English only'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speaking_language.value', value: 'other', label: 'Yes, other'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speaking_language_other.value', value: 'ss', type: 'text'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speaking_language.label', value: 'Do you speak a language other than English at home?', type: 'hidden'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speaking_language_other.label', value: 'Do you speak a language other than English at home?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'How well do you speak English?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speak_english.value', value: 'very-well', label: 'Very Well'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speak_english.value', value: 'well', label: 'Well'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speak_english.value', value: 'not-well', label: 'Not Well'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speak_english.value', value: 'not-at-all', label: 'Not at all'),
                            $this->createSingleChoiceInput(key: 'language_and_cultural_diversity.speak_english.label', value: 'How well do you speak English?', type: 'hidden'),
                        ],
                    ],
                ],
            ],
            'disability' => [
                'title' => 'Disability',
                'queries' => [
                    [
                        'title' => 'Do you consider yourself to have a disability, impairment or long-term condition?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'disability.have_any.value', value: 'yes', label: 'Yes'),
                            $this->createSingleChoiceInput(key: 'disability.have_any.value', value: 'no', label: 'No'),
                            $this->createSingleChoiceInput(key: 'disability.have_any.label', value: 'Do you consider yourself to have a disability, impairment or long-term condition?'),
                        ],
                    ],
                    [
                        'title' => 'If yes, please indicate the area of disability, impairment or long term condition (tick as many as apply)',
                        'subtitle' => null,
                        'choices' => [
                            $this->createDisabilitiesInput(label: 'Hearing/Deaf', value: 'deaf'),
                            $this->createDisabilitiesInput(label: 'Intellectual', value: 'mental-illness'),
                            $this->createDisabilitiesInput(label: 'Mental illness', value: 'physical'),
                            $this->createDisabilitiesInput(label: 'Physical', value: 'learning'),
                            $this->createDisabilitiesInput(label: 'Learning', value: 'medical-condition'),
                            $this->createDisabilitiesInput(label: 'Medical condition', value: 'acquired-brain-impairment'),
                            $this->createDisabilitiesInput(label: 'Acquired brain impairment', value: 'vision'),
                            $this->createDisabilitiesInput(type: 'text'),
                        ],
                    ],
                ],
            ],
            'schooling' => [
                'title' => 'Schooling',
                'queries' => [
                    [
                        'title' => 'Are you still attending secondary school?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'schooling.still_attending.value', value: 'yes', label: 'Yes'),
                            $this->createSingleChoiceInput(key: 'schooling.still_attending.value', value: 'yes', label: 'No'),
                            $this->createSingleChoiceInput(key: 'schooling.still_attending.label', value: 'Are you still attending secondary school?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'What is your highest COMPLETED school level (tick one box only)',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.value', value: '12-equivalent', label: 'Year 12 or equivalent  '),
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.value', value: '11-equivalent', label: 'Year 11 or equivalent'),
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.value', value: '10-equivalent', label: 'Year 10 or equivalent'),
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.value', value: '9-equivalent', label: 'Year 9 or equivalent'),
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.value', value: '8-equivalent', label: 'Year 8 or equivalent'),
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.value', value: 'never', label: 'Never attended school'),
                            $this->createSingleChoiceInput(key: 'schooling.completed_level.label', value: 'Are you still attending secondary school?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'In which YEAR did you complete that school level?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'schooling.completed_year.value', value: '2014', type: 'text'),
                            $this->createSingleChoiceInput(key: 'schooling.completed_year.label', value: 'In which YEAR did you complete that school level?', type: 'hidden'),
                        ],
                    ],
                ],
            ],
            'previous_qualification_achieved' => [
                'title' => 'Previous qualifications achieved',
                'queries' => [
                    [
                        'title' => 'Have you SUCCESSFULLY completed any of the following qualifications?',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'previous_qualification_achieved.completed.value', value: 'yes', label: 'Yes'),
                            $this->createSingleChoiceInput(key: 'previous_qualification_achieved.completed.value', value: 'no', label: 'No'),
                            $this->createSingleChoiceInput(key: 'previous_qualification_achieved.completed.label', value: 'Have you SUCCESSFULLY completed any of the following qualifications?', type: 'hidden'),
                        ],
                    ],
                    [
                        'title' => 'If yes, please enter ONE of these Prior Education Achievement Recognition Identifiers for ANY applicable qualification level.',
                        'subtitle' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International',
                        'choices' => [
                            'bachelor_degree_or_higher_degree' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.bachelor_degree_or_higher_degree.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.bachelor_degree_or_higher_degree.value', value: 'b', label: 'B'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.bachelor_degree_or_higher_degree.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.bachelor_degree_or_higher_degree.label', value: 'bachelor_degree_or_higher_degree', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'bachelor_degree_or_higher_degree', type: 'hidden'),
                            ],
                            'advanced_diploma_or_associate_degree' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.advanced_diploma_or_associate_degree.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.advanced_diploma_or_associate_degree.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.advanced_diploma_or_associate_degree.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.advanced_diploma_or_associate_degree.label', value: 'advanced_diploma_or_associate_degree', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],
                            'diploma_or_associate_diploma' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.diploma_or_associate_diploma.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.diploma_or_associate_diploma.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.diploma_or_associate_diploma.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.diploma_or_associate_diploma.label', value: 'diploma_or_associate_diploma', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],
                            'certificate_iv_or_advanced_certificate_technician' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iv_or_advanced_certificate_technician.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iv_or_advanced_certificate_technician.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iv_or_advanced_certificate_technician.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iv_or_advanced_certificate_technician.label', value: 'certificate_iv_or_advanced_certificate_technician', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],
                            'certificate_iii_or_trade_certificate' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iii_or_trade_certificate.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iii_or_trade_certificate.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iii_or_trade_certificate.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_iii_or_trade_certificate.label', value: 'certificate_iii_or_trade_certificate', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],
                            'certificate_ii' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_ii.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_ii.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_ii.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_ii.label', value: 'certificate_ii', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],
                            'certificate_i' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_i.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_i.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_i.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificate_i.label', value: 'certificate_i', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],
                            'certificates_other_than_the_above' => [
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificates_other_than_the_above.value', value: 'a', label: 'A'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificates_other_than_the_above.value', value: 'e', label: 'E'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificates_other_than_the_above.value', value: 'i', label: 'I'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.level.certificates_other_than_the_above.label', value: 'certificates_other_than_the_above', type: 'hidden'),
                                $this->createSingleChoiceInput(key: 'previous_qualification_achieved.education_achievement.label', value: 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', type: 'hidden'),
                            ],

                        ],
                    ],
                ],
            ],
            'employment' => [
                'title' => 'Employment',
                'queries' => [
                    [
                        'title' => 'Of the following categories, which BEST describes your current employment status? (Tick one box only)',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'full-time', label: 'Full-time employee'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'employer', label: 'Employer'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'unemployed-seeking-part-time', label: 'Unemployed – seeking part-time work'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'part-time', label: 'Part-time employee'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'employed-unpaid-worker-family-business', label: 'Employed – unpaid worker in a family business'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'not-employed-not-seeking-employment', label: 'Not employed – not seeking employment'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'self-employed-not-employing', label: 'Self-employed – not employing others'),
                            $this->createSingleChoiceInput(key: 'employment.status.value', value: 'unemployed-seeking-full-time', label: 'Unemployed – seeking full-time work'),
                            $this->createSingleChoiceInput(key: 'employment.status.label', value: 'Of the following categories, which BEST describes your current employment status? (Tick one box only)', type: 'hidden'),
                        ],
                    ],
                ],
            ],
            'study_reason' => [
                'title' => '',
                'queries' => [
                    [
                        'title' => 'Of the following categories, which BEST describes your main reason for undertaking this course? (Tick one box only)',
                        'subtitle' => null,
                        'choices' => [
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'to-get-a-job', label: 'To get a job'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'it-was-a-requirement-of-my-job', label: 'It was a requirement of my job'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'to-develop-my-existing-business', label: 'To develop my existing business'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'i-wanted-extra-skills-for-my-job', label: 'I wanted extra skills for my job'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'to-start-my-own-business', label: 'To start my own business'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'to-get-into-another-course-of-study', label: 'To get into another course of study'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'to-try-for-a-different-career', label: 'To try for a different career'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'for-personal-interest-or-self-development', label: 'For personal interest or self-development'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'to-get-a-better-job-or-promotion', label: 'To get a better job or promotion'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.value', value: 'other-reasons', label: 'Other reasons'),
                            $this->createSingleChoiceInput(key: 'study_reason.reason.label', value: 'Of the following categories, which BEST describes your main reason for undertaking this course? (Tick one box only)', type: 'hidden'),
                        ],
                    ],
                ],
            ],
        ];
    }

    private function createSingleChoiceInput(string $key, string $value = '', string $label = '', string $type = 'radio'): array
    {
        $explodedKey = explode('.', $key, 6);
        $lastString = end($explodedKey);
        [$name, $id] = $this->getNameAndID($explodedKey, $lastString);

        $inputFields = ['type' => $type, 'name' => $name, 'value' => $value, 'label' => $label, 'id' => $id];
        $type === 'radio' && $inputFields['checked'] = Arr::get($this->surveyData, $key) === $value;
        $type === 'text' && $inputFields['value'] = Arr::get($this->surveyData, $key);

        return $inputFields;
    }

    private function createDisabilitiesInput(string $label = 'Other', string $value = '', string $type = 'checkbox'): array
    {
        $inputFields = [
            'id' => Str::of($value)->start('disabilities-'),
            'type' => $type,
            'name' => 'survey[disabilities][]',
            'label' => $label,
            'value' => '',
        ];
        if ($type == 'checkbox') {
            $inputFields['checked'] = in_array($value, $this->surveyData['disabilities']);
            $inputFields['value'] = $value;
        }
        if ($type == 'text') {
            $inputFields['value'] = end($this->surveyData['disabilities']);
        }

        return $inputFields;
    }

    public function getNameAndID(array $explodedKey, false|string $lastString, string $name = 'survey', string $id = ''): array
    {
        array_walk($explodedKey, function ($key) use ($lastString, &$name, &$id) {
            $id = Str::of($id)->append(
                Str::of($key)->slug()
                    ->when($key == $lastString,
                        fn (Stringable $string) => $string->replaceLast($string, Str::random(6)),
                        fn (Stringable $string) => $string->append('-')
                    )
            );
            $name = Str::of($name)->append(
                Str::of($key)->start('[')->finish(']')
            );
        });

        return [$name, $id];
    }
}
