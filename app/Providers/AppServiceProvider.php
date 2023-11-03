<?php

namespace App\Providers;

use App\Enums\Questionnaire\QuestionType;
use App\Http\Controllers\Questionnaire\Admin\QuestionController;
use App\Services\Questionnaire\Types\ClosedOption;
use App\Services\Questionnaire\Types\DescribeImage;
use App\Services\Questionnaire\Types\InterfaceType;
use App\Services\Questionnaire\Types\ReadAndAnswer;
use App\Services\Questionnaire\Types\TrueFalse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(QuestionnaireServiceProvider::class);
        $this->app->when([QuestionController::class])
            ->needs(InterfaceType::class)
            ->give(function ($app) {
                return match (request()->get('type')) {
                    QuestionType::READ_AND_ANSWER->value => new ReadAndAnswer(),
                    QuestionType::DESCRIBE_IMAGE->value => new DescribeImage(),
                    QuestionType::TRUE_FALSE->value => new TrueFalse(),
                    default => new ClosedOption()
                };
            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment('development')) {
            \Debugbar::disable();
        }
    }
}
