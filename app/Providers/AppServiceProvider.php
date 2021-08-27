<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\DB;

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
        //
        $nav_categories = DB::table('t_categories')
        ->where('Category_SystemStatus', 1)
        ->where('Category_Parent_ID', null)
        ->get();
        view()->share('nav_categories', $nav_categories);
    }
}
