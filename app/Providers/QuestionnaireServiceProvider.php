<?php

namespace App\Providers;

use App\Enums\Questionnaire\QuestionType;
use App\Http\Controllers\Questionnaire\Admin\QuestionController;
use App\Models\Course;
use App\Models\Student;
use App\Questionnaire\AdminFacade;
use App\Questionnaire\Repositories\InterfaceModuleRepo;
use App\Questionnaire\Repositories\InterfaceQuestionRepo;
use App\Questionnaire\Repositories\ModuleRepo;
use App\Questionnaire\Repositories\QuestionRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionClosedOptionRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionDescribeImageRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionMultipleChoiceRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionReadAndAnswerRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionSeeAndAnswerRepo;
use App\Questionnaire\Repositories\Types\InterfaceQuestionTrueFalseRepo;
use App\Questionnaire\Repositories\Types\QuestionClosedOptionRepo;
use App\Questionnaire\Repositories\Types\QuestionDescribeImageRepo;
use App\Questionnaire\Repositories\Types\QuestionMultipleChoiceRepo;
use App\Questionnaire\Repositories\Types\QuestionReadAndAnswerRepo;
use App\Questionnaire\Repositories\Types\QuestionSeeAndAnswerRepo;
use App\Questionnaire\Repositories\Types\QuestionTrueFalseRepo;
use App\Questionnaire\Services\Admin\InterfaceAdmin;
use App\Questionnaire\Services\Admin\TrueFalseAdmin;
use App\Questionnaire\StudentFacade;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class QuestionnaireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerFacades();
        $this->registerInterfaces();
        $this->registerContextualInterface();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('open-course', function (Student $student, Course $course) {
            return $course->students()->where('student_id', $student->getAttribute('id'))->exists();
        });
    }

    private function registerInterfaces(): void
    {
        $this->app->singleton(InterfaceModuleRepo::class, ModuleRepo::class);
        $this->app->singleton(InterfaceQuestionRepo::class, QuestionRepo::class);
        $this->app->singleton(InterfaceQuestionClosedOptionRepo::class, QuestionClosedOptionRepo::class);
        $this->app->singleton(InterfaceQuestionMultipleChoiceRepo::class, QuestionMultipleChoiceRepo::class);
        $this->app->singleton(InterfaceQuestionDescribeImageRepo::class, QuestionDescribeImageRepo::class);
        $this->app->singleton(InterfaceQuestionTrueFalseRepo::class, QuestionTrueFalseRepo::class);
        $this->app->singleton(InterfaceQuestionReadAndAnswerRepo::class, QuestionReadAndAnswerRepo::class);
        $this->app->singleton(InterfaceQuestionSeeAndAnswerRepo::class, QuestionSeeAndAnswerRepo::class);
    }

    private function registerFacades(): void
    {
        $this->app->singleton('admin-facade', function ($app) {
            return new AdminFacade(
                $app->make(InterfaceModuleRepo::class),
                $app->make(InterfaceQuestionRepo::class),
                $app->make(InterfaceQuestionClosedOptionRepo::class),
                $app->make(InterfaceQuestionMultipleChoiceRepo::class),
                $app->make(InterfaceQuestionDescribeImageRepo::class),
                $app->make(InterfaceQuestionSeeAndAnswerRepo::class),
                $app->make(InterfaceQuestionTrueFalseRepo::class),
                $app->make(InterfaceQuestionReadAndAnswerRepo::class),
            );
        });
        $this->app->singleton('student-facade', fn ($app) => new StudentFacade());
    }

    private function registerContextualInterface(): void
    {
        $this->app->when(QuestionController::class)
            ->needs(InterfaceAdmin::class)
            ->give(function () {
                if (! App::runningInConsole()) {
                    return QuestionType::from(request()->get('type'))->getAdminServiceObject();
                } else {
                    return new TrueFalseAdmin();
                }
            });
    }
}
