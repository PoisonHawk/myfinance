<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Bills;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.main', function($view){
            $view->with('user_bills', Bills::userBills());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
