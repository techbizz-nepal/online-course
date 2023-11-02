<?php

use App\DTO\Questionnaire\QuestionData;
use App\DTO\Questionnaire\QuestionDescribeImageData;
use App\DTO\Questionnaire\QuestionOptionData;
use App\DTO\Questionnaire\QuestionTrueFalseData;
use App\Enums\Questionnaire\QuestionType;
use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Models\Questionnaire\Module;
use App\Models\Questionnaire\Question;
use Database\Seeders\AssessmentSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\ModuleSeeder;

uses()->group('questionnaire');
beforeEach(function () {
    $this->seed(CategorySeeder::class);
    $this->seed(CourseSeeder::class);
    $this->seed(AssessmentSeeder::class);
    $this->seed(ModuleSeeder::class);
});
it('can create module', function () {
    $module = Module::factory()->create();
    expect($module->count())->toBeGreaterThan(0);
});
it('can create question', function () {
    $module = tap(Module::query()->first())->target;
    $questionData = QuestionData::from([
        'body' => fake()->paragraph,
        'type' => QuestionType::TRUE_FALSE->value,
    ]);
    $question = QuestionnaireAdmin::createQuestion($module, $questionData);
    expect($question)->module_id->toBe($module->id);
});
it('can create/update true false question', function () {
    $question = Question::factory()->create();
    $questionTrueFalseData = QuestionTrueFalseData::from([
        'is_true' => true,
    ]);
    $questionTrueFalseCreate = QuestionnaireAdmin::createQuestionTrueFalse($question, $questionTrueFalseData);
    //create
    expect($questionTrueFalseCreate)
        ->question_id->toBe($question->id)
        ->and($questionTrueFalseCreate)
        ->is_true->toBe($questionTrueFalseData->is_true);
    $questionTrueFalseCreateData = QuestionTrueFalseData::from([
        'is_true' => false,
    ]);
    $questionTrueFalseUpdate = QuestionnaireAdmin::updateQuestionTrueFalse($question, $questionTrueFalseCreateData);
    //update
    expect($questionTrueFalseUpdate)
        ->question_id->toBe($question->getAttribute('id'))
        ->and($questionTrueFalseUpdate)
        ->is_true->toBe(intval($questionTrueFalseCreateData->is_true));
});
it('can create/update describe image question', function () {
    $question = Question::factory()->create();
    $questionDescribeImageData = QuestionDescribeImageData::from([
        'image_path' => 'some-path.jpg',
    ]);
    $questionDescribeImageCreate = QuestionnaireAdmin::createQuestionDescribeImage($question, $questionDescribeImageData);
    //create
    expect($questionDescribeImageCreate)
        ->question_id->toBe($question->getAttribute('id'))
        ->and($questionDescribeImageCreate)
        ->image_path->toBe($questionDescribeImageData->image_path);
    $questionDescribeImageData = QuestionDescribeImageData::from([
        'image_path' => 'another-path.jpg',
    ]);
    $questionDescribeImageUpdate = QuestionnaireAdmin::updateQuestionDescribeImage($question, $questionDescribeImageData);
    //update
    expect($questionDescribeImageUpdate)
        ->question_id->toBe($question->id)
        ->and($questionDescribeImageUpdate)->image_path
        ->toBe($questionDescribeImageData->image_path);
});
it('can create/update closed option question', function () {
    $question = Question::factory()->create();
    $questionOptionsData = QuestionOptionData::from([
        'body' => [
            'option1' => 'option 1 text',
            'option2' => 'option 2 text',
            'option3' => 'option 3 text',
            'option4' => 'option 4 text',
        ],
        'is_correct' => 'option1',
    ]);
    $questionOptionCreate = QuestionnaireAdmin::createQuestionOption($question, $questionOptionsData);
    //create
    expect($questionOptionCreate)
        ->question_id->toBe($question->getAttribute('id'))
        ->and($questionOptionCreate)
        ->is_correct->toBe($questionOptionsData->is_correct);
    $questionOptionsData = QuestionOptionData::from([
        'body' => [
            'option1' => 'option 1 text',
            'option2' => 'option 2 text',
            'option3' => 'option 3 text',
            'option4' => 'option 4 text',
        ],
        'is_correct' => 'option2',
    ]);
    $questionOptionUpdate = QuestionnaireAdmin::updateQuestionOption($question, $questionOptionsData);
    //update
    expect($questionOptionUpdate)
        ->question_id->toBe($question->getAttribute('id'))
        ->and($questionOptionUpdate)
        ->is_correct->toBe($questionOptionsData->is_correct);
});
it('can create/update read and answer question', function () {

});
