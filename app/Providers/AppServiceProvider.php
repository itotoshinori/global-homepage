<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App; // 追加
use Illuminate\Support\Facades\URL; // 追加
use App\lib\mycondition;

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
        $condition = config('mycondition.condition');
        if ($condition == 'production') {
            URL::forceScheme('https');
        }
    }
}
