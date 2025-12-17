<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        //Link with public folder
        View::share('publicDir', asset('public'));
        View::share('backendDir', asset('public/backend'));
        View::share('fronendDir', asset('public/frontend'));
        View::share('viewDir', asset('application/resources/views'));
        View::share('moduleDir', asset('module'));

        //helpers
        View::share('Query', '\App\Helpers\Query');
        View::share('ButtonSet', '\App\Helpers\ButtonSet');
        View::share('NavMenu', '\App\Helpers\NavMenu');
        View::share('Core', '\App\Helpers\Core');
        $this->loadViewsFrom(base_path('module'), 'module');
        //Model
        View::share('Model', function($modelName){
            $modelPath = '\App\Models' . '\\' . $modelName;
            return $modelPath;
        });
    }
}
