<?php

namespace App\Providers;

use App\Services\Questionnaire\AdminService;
use App\Services\Questionnaire\StudentService;
use App\Services\Questionnaire\Utilities\AssessmentService;
use App\Services\Questionnaire\Utilities\InterfaceAssessmentService;
use App\Services\Questionnaire\Utilities\InterfaceModuleService;
use App\Services\Questionnaire\Utilities\InterfaceQuestionService;
use App\Services\Questionnaire\Utilities\ModuleService;
use App\Services\Questionnaire\Utilities\QuestionService;
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
        $this->app->singleton(InterfaceAssessmentService::class, AssessmentService::class);
        $this->app->singleton(InterfaceModuleService::class, ModuleService::class);
        $this->app->singleton(InterfaceQuestionService::class, QuestionService::class);
    }

    private function registerFacades(): void
    {
        $this->app->singleton('admin-service', function ($app) {
            return new AdminService(
                $app->make(InterfaceAssessmentService::class),
                $app->make(InterfaceModuleService::class),
                $app->make(InterfaceQuestionService::class)
            );
        });
        $this->app->singleton('student-service', fn () => new StudentService());
    }
}
