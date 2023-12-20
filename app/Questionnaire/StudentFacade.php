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
                            ['type' => 'radio', 'checked' => $this->assertValue('general.studied_before.value', 'yes'), 'id' => 'studied-before-yes', 'value' => 'yes', 'name' => 'survey[general][studied_before][value]', 'label' => 'Yes'],
                            ['type' => 'radio', 'checked' => $this->assertValue('general.studied_before.value', 'no'), 'id' => 'studied-before-no', 'value' => 'no', 'name' => 'survey[general][studied_before][value]', 'label' => 'No'],
                            ['type' => 'hidden', 'id' => 'studied-before-label', 'value' => 'Have you ever studied with Knowledge Empowers You before?', 'name' => 'survey[general][studied_before][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'Do you wish to apply for Credit?',
                        'subtitle' => 'If YES, certified copies of transcripts from previous qualifications must be provided with this form, along with a Credit Application Form.',
                        'choices' => [
                            ['type' => 'radio', 'checked' => $this->assertValue('general.apply_credit.value', 'yes'), 'id' => 'apply-credit-yes', 'name' => 'survey[general][apply_credit][value]', 'value' => 'yes', 'label' => 'Yes'],
                            ['type' => 'radio', 'checked' => $this->assertValue('general.apply_credit.value', 'no'), 'id' => 'apply-credit-no', 'name' => 'survey[general][apply_credit][value]', 'value' => 'no', 'label' => 'No'],
                            ['type' => 'radio', 'checked' => $this->assertValue('general.apply_credit.value', 'maybe'), 'id' => 'apply-credit-maybe', 'name' => 'survey[general][apply_credit][value]', 'value' => 'maybe', 'label' => 'Maybe I’d like more information'],
                            ['type' => 'hidden', 'id' => 'apply-credit-label', 'value' => 'Do you wish to apply for Credit?', 'name' => 'survey[general][apply_credit][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'Do you wish to apply for Recognition of Prior Learning?',
                        'subtitle' => 'If you indicate YES, you will be contacted to discuss this further.',
                        'choices' => [
                            ['type' => 'radio', 'checked' => $this->assertValue('general.prior_learning.value', 'yes'), 'id' => 'recognition-prior-learning-yes', 'name' => 'survey[general][prior_learning][value]', 'value' => 'yes', 'label' => 'Yes'],
                            ['type' => 'radio', 'checked' => $this->assertValue('general.prior_learning.value', 'no'), 'id' => 'recognition-prior-learning-no', 'name' => 'survey[general][prior_learning][value]', 'value' => 'no', 'label' => 'No'],
                            ['type' => 'radio', 'checked' => $this->assertValue('general.prior_learning.value', 'maybe'), 'id' => 'recognition-prior-learning-maybe', 'name' => 'survey[general][prior_learning][value]', 'value' => 'maybe', 'label' => 'Maybe I’d like more information'],
                            ['type' => 'hidden', 'id' => 'recognition-prior-learning-label', 'value' => 'Do you speak a language other than English at home?', 'name' => 'survey[general][prior_learning][label]', 'label' => ''],
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
                            ['type' => 'radio', 'id' => 'country-born-australia', 'value' => 'australia', 'checked' => $this->assertValue('language_and_cultural_diversity.country_born.value', 'australia'), 'name' => 'survey[language_and_cultural_diversity][country_born][value]', 'label' => 'Australia'],
                            ['type' => 'radio', 'id' => 'country-born-other', 'value' => 'other', 'checked' => $this->assertValue('language_and_cultural_diversity.country_born.value', 'other'), 'name' => 'survey[language_and_cultural_diversity][country_born][value]', 'label' => 'Other'],
                            ['type' => 'text', 'id' => 'country-born-specify', 'value' => $this->getValueByKey('language_and_cultural_diversity.country_born_other.value'), 'name' => 'survey[language_and_cultural_diversity][country_born_other][value]', 'label' => 'please specify: '],
                            ['type' => 'hidden', 'id' => 'country-born-label', 'value' => 'Do you speak a language other than English at home?', 'name' => 'survey[language_and_cultural_diversity][country_born][label]', 'label' => ''],
                            ['type' => 'hidden', 'id' => 'country-born-other-label', 'value' => 'Do you speak a language other than English at home?', 'name' => 'survey[language_and_cultural_diversity][country_born_other][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'Do you speak a language other than English at home?',
                        'subtitle' => 'If more than one language, indicate the one that is spoken most often.',
                        'choices' => [
                            ['type' => 'radio', 'id' => 'speaking-language-english', 'value' => 'english', 'checked' => $this->assertValue('language_and_cultural_diversity.speaking_language.value', 'english'), 'name' => 'survey[language_and_cultural_diversity][speaking_language][value]', 'label' => 'No, English only'],
                            ['type' => 'radio', 'id' => 'speaking-language-other', 'value' => 'other', 'checked' => $this->assertValue('language_and_cultural_diversity.speaking_language.value', 'other'), 'name' => 'survey[language_and_cultural_diversity][speaking_language][value]', 'label' => 'Yes, other'],
                            ['type' => 'text', 'id' => 'speaking-language-specify', 'value' => $this->getValueByKey('language_and_cultural_diversity.speaking_language_other.value'), 'name' => 'survey[language_and_cultural_diversity][speaking_language_other][value]', 'label' => 'please specify: '],
                            ['type' => 'hidden', 'id' => 'speaking-language-label', 'value' => 'Do you speak a language other than English at home?', 'name' => 'survey[language_and_cultural_diversity][speaking_language][label]', 'label' => ''],
                            ['type' => 'hidden', 'id' => 'speaking-language-other-label', 'value' => 'Do you speak a language other than English at home?', 'name' => 'survey[language_and_cultural_diversity][speaking_language_other][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'How well do you speak English?',
                        'subtitle' => null,
                        'choices' => [
                            ['type' => 'radio', 'id' => 'speak-english-very-well', 'value' => 'very-well', 'checked' => $this->assertValue('language_and_cultural_diversity.speak_english.value', 'very-well'), 'name' => 'survey[language_and_cultural_diversity][speak_english][value]', 'label' => 'Very Well'],
                            ['type' => 'radio', 'id' => 'speak-english-well', 'value' => 'well', 'checked' => $this->assertValue('language_and_cultural_diversity.speak_english.value', 'well'), 'name' => 'survey[language_and_cultural_diversity][speak_english][value]', 'label' => 'Well'],
                            ['type' => 'radio', 'id' => 'speak-english-not-well', 'value' => 'not-well', 'checked' => $this->assertValue('language_and_cultural_diversity.speak_english.value', 'not-well'), 'name' => 'survey[language_and_cultural_diversity][speak_english][value]', 'label' => 'Not Well'],
                            ['type' => 'radio', 'id' => 'speak-english-not-at-all', 'value' => 'not-at-all', 'checked' => $this->assertValue('language_and_cultural_diversity.speak_english.value', 'not-at-all'), 'name' => 'survey[language_and_cultural_diversity][speak_english][value]', 'label' => 'Not at all'],
                            ['type' => 'hidden', 'id' => 'speak-english-label', 'value' => 'How well do you speak English?', 'name' => 'survey[language_and_cultural_diversity][speak_english][label]', 'label' => ''],
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
                            ['type' => 'radio', 'id' => 'have-any-yes', 'value' => 'yes', 'checked' => $this->assertValue('disability.have_any.value', 'yes'), 'name' => 'survey[disability][have_any][value]', 'label' => 'Yes'],
                            ['type' => 'radio', 'id' => 'have-any-no', 'value' => 'no', 'checked' => $this->assertValue('disability.have_any.value', 'no'), 'name' => 'survey[disability][have_any][value]', 'label' => 'No'],
                            ['type' => 'hidden', 'id' => 'have-any-label', 'value' => 'Do you consider yourself to have a disability, impairment or long-term condition?', 'name' => 'survey[disability][have_any][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'If yes, please indicate the area of disability, impairment or long term condition (tick as many as apply)',
                        'subtitle' => null,
                        'choices' => [
                            ['type' => 'checkbox', 'id' => 'disabilities-deaf', 'value' => 'deaf', 'checked' => $this->hasDisability('deaf'), 'name' => 'survey[disabilities][]', 'label' => 'Hearing/deaf'],
                            ['type' => 'checkbox', 'id' => 'disabilities-intellectual', 'value' => 'intellectual', 'checked' => $this->hasDisability('intellectual'), 'name' => 'survey[disabilities][]', 'label' => 'Intellectual'],
                            ['type' => 'checkbox', 'id' => 'disabilities-mental-illness', 'value' => 'mental-illness', 'checked' => $this->hasDisability('mental-illness'), 'name' => 'survey[disabilities][]', 'label' => 'Mental illness'],
                            ['type' => 'checkbox', 'id' => 'disabilities-physical', 'value' => 'physical', 'checked' => $this->hasDisability('physical'), 'name' => 'survey[disabilities][]', 'label' => 'Physical'],
                            ['type' => 'checkbox', 'id' => 'disabilities-learning', 'value' => 'learning', 'checked' => $this->hasDisability('learning'), 'name' => 'survey[disabilities][]', 'label' => 'Learning'],
                            ['type' => 'checkbox', 'id' => 'disabilities-medical-condition', 'value' => 'medical-condition', 'checked' => $this->hasDisability('medical-condition'), 'name' => 'survey[disabilities][]', 'label' => 'Medical condition'],
                            ['type' => 'checkbox', 'id' => 'disabilities-acquired-brain-impairment', 'value' => 'acquired-brain-impairment', 'checked' => $this->hasDisability('acquired-brain-impairment'), 'name' => 'survey[disabilities][]', 'label' => 'Acquired brain impairment'],
                            ['type' => 'checkbox', 'id' => 'disabilities-Vision', 'value' => 'vision', 'checked' => $this->hasDisability('vision'), 'name' => 'survey[disabilities][]', 'label' => 'Vision'],
                            ['type' => 'text', 'id' => 'disabilities-Other', 'value' => $this->hasDisability('other'), 'name' => 'survey[disabilities][]', 'label' => 'Other'],
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
                            ['type' => 'radio', 'id' => 'still-attending-yes', 'value' => 'yes', 'checked' => $this->assertValue('schooling.still_attending.value', 'yes'), 'name' => 'survey[schooling][still_attending][value]', 'label' => 'Yes'],
                            ['type' => 'radio', 'id' => 'still-attending-no', 'value' => 'yes', 'checked' => $this->assertValue('schooling.still_attending.value', 'no'), 'name' => 'survey[schooling][still_attending][value]', 'label' => 'No'],
                            ['type' => 'hidden', 'id' => 'still-attending-label', 'value' => 'Are you still attending secondary school?', 'name' => 'survey[schooling][still_attending][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'What is your highest COMPLETED school level (tick one box only)',
                        'subtitle' => null,
                        'choices' => [
                            ['type' => 'radio', 'id' => 'completed-level-12-equivalent', 'value' => '12-equivalent', 'checked' => $this->assertValue('schooling.completed_level.value', '12-equivalent'), 'name' => 'survey[schooling][completed_level][value]', 'label' => 'Year 12 or equivalent  '],
                            ['type' => 'radio', 'id' => 'completed-level-11-equivalent', 'value' => '11-equivalent', 'checked' => $this->assertValue('schooling.completed_level.value', '11-equivalent'), 'name' => 'survey[schooling][completed_level][value]', 'label' => 'Year 11 or equivalent'],
                            ['type' => 'radio', 'id' => 'completed-level-10-equivalent', 'value' => '10-equivalent', 'checked' => $this->assertValue('schooling.completed_level.value', '10-equivalent'), 'name' => 'survey[schooling][completed_level][value]', 'label' => 'Year 10 or equivalent'],
                            ['type' => 'radio', 'id' => 'completed-level-9-equivalent', 'value' => '9-equivalent', 'checked' => $this->assertValue('schooling.completed_level.value', '9-equivalent'), 'name' => 'survey[schooling][completed_level][value]', 'label' => 'Year 9 or equivalent'],
                            ['type' => 'radio', 'id' => 'completed-level-8-equivalent', 'value' => '8-equivalent', 'checked' => $this->assertValue('schooling.completed_level.value', '8-equivalent'), 'name' => 'survey[schooling][completed_level][value]', 'label' => 'Year 8 or equivalent'],
                            ['type' => 'radio', 'id' => 'completed-level-never', 'value' => 'never', 'checked' => $this->assertValue('schooling.completed_level.value', 'never'), 'name' => 'survey[schooling][completed_level][value]', 'label' => 'Never attended school'],
                            ['type' => 'hidden', 'id' => 'completed-level-label', 'value' => 'Are you still attending secondary school?', 'name' => 'survey[schooling][completed_level][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'In which YEAR did you complete that school level?',
                        'subtitle' => null,
                        'choices' => [
                            ['type' => 'text', 'id' => 'completed-year', 'value' => $this->getValueByKey('schooling.completed_year.value'), 'name' => 'survey[schooling][completed_year][value]', 'label' => ''],
                            ['type' => 'hidden', 'id' => 'completed-year-label', 'value' => 'In which YEAR did you complete that school level?', 'name' => 'survey[schooling][completed_year][label]', 'label' => ''],
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
                            ['type' => 'radio', 'id' => 'completed-yes', 'value' => 'yes', 'checked' => $this->assertValue('previous_qualification_achieved.completed.value', 'yes'), 'name' => 'survey[previous_qualification_achieved][completed][value]', 'label' => 'Yes'],
                            ['type' => 'radio', 'id' => 'completed-no', 'value' => 'no', 'checked' => $this->assertValue('previous_qualification_achieved.completed.value', 'no'), 'name' => 'survey[previous_qualification_achieved][completed][value]', 'label' => 'No'],
                            ['type' => 'hidden', 'id' => 'completed-label', 'value' => 'Have you SUCCESSFULLY completed any of the following qualifications?', 'name' => 'survey[previous_qualification_achieved][completed][label]', 'label' => ''],
                        ],
                    ],
                    [
                        'title' => 'If yes, please enter ONE of these Prior Education Achievement Recognition Identifiers for ANY applicable qualification level.',
                        'subtitle' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International',
                        'choices' => [
                            'bachelor_degree_or_higher_degree' => [
                                ['type' => 'radio', 'id' => 'education-achievement-bachelor-degree-or-higher-degree-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.bachelor_degree_or_higher_degree.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][bachelor_degree_or_higher_degree][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-bachelor-degree-or-higher-degree-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.bachelor_degree_or_higher_degree.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][bachelor_degree_or_higher_degree][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-bachelor-degree-or-higher-degree-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.bachelor_degree_or_higher_degree.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][bachelor_degree_or_higher_degree][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-bachelor-degree-or-higher-degree-choice-title', 'value' => 'bachelor_degree_or_higher_degree', 'name' => 'survey[previous_qualification_achieved][education_achievement][bachelor_degree_or_higher_degree][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-bachelor-degree-or-higher-degree-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'advanced_diploma_or_associate_degree' => [
                                ['type' => 'radio', 'id' => 'education-achievement-advanced-diploma-or-associate-degree-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.advanced_diploma_or_associate_degree.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][advanced_diploma_or_associate_degree][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-advanced-diploma-or-associate-degree-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.advanced_diploma_or_associate_degree.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][advanced_diploma_or_associate_degree][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-advanced-diploma-or-associate-degree-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.advanced_diploma_or_associate_degree.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][advanced_diploma_or_associate_degree][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-advanced-diploma-or-associate-degree-choice-title', 'value' => 'advanced_diploma_or_associate_degree', 'name' => 'survey[previous_qualification_achieved][education_achievement][advanced_diploma_or_associate_degree][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-advanced-diploma-or-associate-degree-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'diploma_or_associate_diploma' => [
                                ['type' => 'radio', 'id' => 'education-achievement-diploma-or-associate-diploma-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.diploma_or_associate_diploma.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][diploma_or_associate_diploma][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-diploma-or-associate-diploma-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.diploma_or_associate_diploma.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][diploma_or_associate_diploma][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-diploma-or-associate-diploma-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.diploma_or_associate_diploma.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][diploma_or_associate_diploma][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-diploma-or-associate-diploma-choice-title', 'value' => 'diploma_or_associate_diploma', 'name' => 'survey[previous_qualification_achieved][education_achievement][diploma_or_associate_diploma][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-diploma-or-associate-diploma-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'certificate_iv_or_advanced_certificate_technician' => [
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-iv-or-advanced-certificate-technician-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_iv_or_advanced_certificate_technician.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iv_or_advanced_certificate_technician][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-iv-or-advanced-certificate-technician-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_iv_or_advanced_certificate_technician.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iv_or_advanced_certificate_technician][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-iv-or-advanced-certificate-technician-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_iv_or_advanced_certificate_technician.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iv_or_advanced_certificate_technician][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-iv-or-advanced-certificate-technician-choice-title', 'value' => 'certificate_iv_or_advanced_certificate_technician', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iv_or_advanced_certificate_technician][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-iv-or-advanced-certificate-technician-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'certificate_iii_or_trade_certificate' => [
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-iii-or-trade_certificate-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_iii_or_trade_certificate.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iii_or_trade_certificate][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-iii-or-trade_certificate-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_iii_or_trade_certificate.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iii_or_trade_certificate][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-iii-or-trade_certificate-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_iii_or_trade_certificate.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iii_or_trade_certificate][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-iii-or-trade_certificate-choice-title', 'value' => 'certificate_iii_or_trade_certificate', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_iii_or_trade_certificate][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-iii-or-trade_certificate-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'certificate_ii' => [
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-ii-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_ii.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_ii][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-ii-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_ii.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_ii][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-ii-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_ii.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_ii][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-ii-choice-title', 'value' => 'certificate_ii', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_ii][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-ii-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'certificate_i' => [
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-i-a', 'value' => 'a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_i.value', 'a'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_i][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-i-e', 'value' => 'e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_i.value', 'e'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_i][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificate-i-i', 'value' => 'i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificate_i.value', 'i'), 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_i][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-i-choice-title', 'value' => 'certificate_i', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificate_i][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificate-i-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
                            ],
                            'certificates_other_than_the_above' => [
                                ['type' => 'radio', 'id' => 'education-achievement-certificates-other-than-the-above-a', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificates_other_than_the_above.value', 'a'), 'value' => 'a', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificates_other_than_the_above][value]', 'label' => 'A'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificates-other-than-the-above-e', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificates_other_than_the_above.value', 'e'), 'value' => 'e', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificates_other_than_the_above][value]', 'label' => 'E'],
                                ['type' => 'radio', 'id' => 'education-achievement-certificates-other-than-the-above-i', 'checked' => $this->assertValue('previous_qualification_achieved.education_achievement.certificates_other_than_the_above.value', 'i'), 'value' => 'i', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificates_other_than_the_above][value]', 'label' => 'I'],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificates-other-than-the-above-choice-title', 'value' => 'certificates_other_than_the_above', 'name' => 'survey[previous_qualification_achieved][education_achievement][certificates_other_than_the_above][label]', 'label' => ''],
                                ['type' => 'hidden', 'id' => 'education-achievement-certificates-other-than-the-above-title', 'value' => 'If you have multiple Prior Education Achievement Recognition Identifiers for any one qualification, use the following priority order to determine which identifier to use: 1. A – Australian 2. E– Australian equivalent 3. I – International', 'name' => 'survey[previous_qualification_achieved][education_achievement][label]', 'label' => ''],
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
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'full-time'), 'id' => 'status-full-time', 'label' => 'Full-time employee', 'value' => 'full-time', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'employer'), 'id' => 'status-employer', 'label' => 'Employer', 'value' => 'employer', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'unemployed-seeking-part-time'), 'id' => 'status-unemployed-seeking-part-time', 'label' => 'Unemployed – seeking part-time work', 'value' => 'unemployed-seeking-part-time', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'part-time'), 'id' => 'status-part-time', 'label' => 'Part-time employee', 'value' => 'part-time', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'employed-unpaid-worker-family-business'), 'id' => 'status-employed-unpaid-worker-family-business', 'label' => 'Employed – unpaid worker in a family business', 'value' => 'employed-unpaid-worker-family-business', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'employed-unpaid-worker-family-business'), 'id' => 'status-not-employed-not-seeking-employment', 'label' => 'Not employed – not seeking employment', 'value' => 'not-employed-not-seeking-employment', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'self-employed-not-employing'), 'id' => 'status-self-employed-not-employing', 'label' => 'Self-employed – not employing others', 'value' => 'self-employed-not-employing', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'radio', 'checked' => $this->assertValue('employment.status.value', 'unemployed-seeking-full-time'), 'id' => 'status-unemployed-seeking-full-time', 'label' => 'Unemployed – seeking full-time work', 'value' => 'unemployed-seeking-full-time', 'name' => 'survey[employment][status][value]'],
                            ['type' => 'hidden', 'id' => 'status-title', 'label' => '', 'value' => 'Of the following categories, which BEST describes your current employment status? (Tick one box only)', 'name' => 'survey[employment][status][label]'],
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
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'to-get-a-job'), 'value' => 'to-get-a-job', 'label' => 'To get a job', 'id' => 'reason-to-get-a-job'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'it-was-a-requirement-of-my-job'), 'value' => 'it-was-a-requirement-of-my-job', 'label' => 'It was a requirement of my job', 'id' => 'reason-it-was-a-requirement-of-my-job'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'to-develop-my-existing-business'), 'value' => 'to-develop-my-existing-business', 'label' => 'To develop my existing business', 'id' => 'reason-to-develop-my-existing-business'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'i-wanted-extra-skills-for-my-job'), 'value' => 'i-wanted-extra-skills-for-my-job', 'label' => 'I wanted extra skills for my job', 'id' => 'reason-i-wanted-extra-skills-for-my-job'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'to-start-my-own-business'), 'value' => 'to-start-my-own-business', 'label' => 'To start my own business', 'id' => 'reason-to-start-my-own-business'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'to-get-into-another-course-of-study'), 'value' => 'to-get-into-another-course-of-study', 'label' => 'To get into another course of study', 'id' => 'reason-to-get-into-another-course-of-study'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'to-try-for-a-different-career'), 'value' => 'to-try-for-a-different-career', 'label' => 'To try for a different career', 'id' => 'reason-to-try-for-a-different-career'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'for-personal-interest-or-self-development'), 'value' => 'for-personal-interest-or-self-development', 'label' => 'For personal interest or self-development', 'id' => 'reason-for-personal-interest-or-self-development'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'to-get-a-better-job-or-promotion'), 'value' => 'to-get-a-better-job-or-promotion', 'label' => 'To get a better job or promotion', 'id' => 'reason-for-personal-interest-or-self-development'],
                            ['type' => 'radio', 'name' => 'survey[study_reason][reason][value]', 'checked' => $this->assertValue('study_reason.reason.value', 'other-reasons'), 'value' => 'other-reasons', 'label' => 'Other reasons', 'id' => 'reason-other-reasons'],
                            ['type' => 'hidden', 'name' => 'survey[study_reason][reason][label]', 'value' => 'Of the following categories, which BEST describes your main reason for undertaking this course? (Tick one box only)', 'label' => '', 'id' => ''],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function assertValue(string $key, string $needle): bool
    {
        return Arr::get($this->surveyData, $key) == $needle;
    }

    private function getValueByKey(string $key): string|array|null
    {
        return Arr::get($this->surveyData, $key);
    }

    private function hasDisability(string $value): bool|string
    {
        if ($value == 'other') {
            return end($this->surveyData['disabilities']) ?? false;
        }

        return in_array($value, $this->surveyData['disabilities']);
    }
}
