<?php

namespace App\Providers;

use App\Enums\Questionnaire\QuestionType;
use App\Http\Controllers\Questionnaire\Admin\QuestionController;
use App\Services\Questionnaire\Types\ClosedOption;
use App\Services\Questionnaire\Types\DescribeImage;
use App\Services\Questionnaire\Types\InterfaceType;
use App\Services\Questionnaire\Types\ReadAndAnswer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
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
//        DB::listen(function($query) {
//            Log::info(
//                $query->sql,
//                [
//                    'bindings' => $query->bindings,
//                    'time' => $query->time
//                ]
//            );
//        });
    }
}
