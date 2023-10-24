<?php

namespace App\Providers;

use App\Facades\Questionnaire\QuestionnaireAdmin;
use App\Facades\Questionnaire\QuestionnaireStudent;
use App\Services\Questionnaire\AdminService;
use App\Services\Questionnaire\StudentService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class QuestionnaireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerFacades();
//        $this->registerAliases();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerFacades(): void
    {
        $this->app->singleton('admin-service', fn() => new AdminService());
        $this->app->singleton('student-service', fn() => new StudentService());
    }

    private function registerAliases(): void
    {
        AliasLoader::getInstance()->alias('QuestionnaireAdmin', QuestionnaireAdmin::class);
        AliasLoader::getInstance()->alias('QuestionnaireStudent', QuestionnaireStudent::class);
    }
}
