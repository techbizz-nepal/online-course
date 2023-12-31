<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->registerPlatformRoutes();
            $this->registerAdminRoutes();
            $this->registerStudentRoutes();
            $this->questionnaireRoutes();
        });
    }

    private function registerPlatformRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    private function registerAdminRoutes(): void
    {
        Route::middleware('web')
            ->prefix('admin')
            ->name('admin.')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/admin/index.php'));
    }

    private function registerStudentRoutes(): void
    {
        Route::prefix('student')
            ->middleware('web')
            ->name('student.')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/student/index.php'));
    }

    private function questionnaireRoutes(): void
    {
        Route::middleware(['web', 'auth:web'])
            ->prefix('admin')
            ->name('admin.')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/questionnaire/admin.php'));

        Route::middleware(['web', 'auth:student'])
            ->prefix('student')
            ->name('student.')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/questionnaire/student.php'));
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
