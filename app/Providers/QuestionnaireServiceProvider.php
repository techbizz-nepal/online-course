<?php

namespace App\Providers;

use App\Enums\Questionnaire\QuestionType;
use App\Http\Controllers\Questionnaire\Admin\QuestionController;
use App\Questionnaire\AdminFacade;
use App\Questionnaire\Repositories\AssessmentRepo;
use App\Questionnaire\Repositories\InterfaceAssessmentRepo;
use App\Questionnaire\Repositories\InterfaceModuleRepo;
use App\Questionnaire\Repositories\InterfaceQuestionRepo;
use App\Questionnaire\Repositories\ModuleRepo;
use App\Questionnaire\Repositories\QuestionRepo;
use App\Questionnaire\Services\Admin\InterfaceAdmin;
use App\Questionnaire\Services\Admin\TrueFalseAdmin;
use App\Questionnaire\StudentFacade;
use Illuminate\Support\Facades\App;
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
        //
    }

    private function registerInterfaces(): void
    {
        $this->app->singleton(InterfaceAssessmentRepo::class, AssessmentRepo::class);
        $this->app->singleton(InterfaceModuleRepo::class, ModuleRepo::class);
        $this->app->singleton(InterfaceQuestionRepo::class, QuestionRepo::class);
    }

    private function registerFacades(): void
    {
        $this->app->singleton('admin-facade', function ($app) {
            return new AdminFacade(
                $app->make(InterfaceAssessmentRepo::class),
                $app->make(InterfaceModuleRepo::class),
                $app->make(InterfaceQuestionRepo::class)
            );
        });
        $this->app->singleton('student-facade', fn ($app) => new StudentFacade(
            $app->make(InterfaceAssessmentRepo::class),
            $app->make(InterfaceModuleRepo::class),
            $app->make(InterfaceQuestionRepo::class)
        ));
    }

    private function registerContextualInterface(): void
    {
        $this->app->when([QuestionController::class])
            ->needs(InterfaceAdmin::class)
            ->give(function () {
                if (!App::runningInConsole()) {
                    return QuestionType::from(request()->get('type'))->getAdminServiceObject();
                } else {
                    return new TrueFalseAdmin();
                }
            });
    }
}
