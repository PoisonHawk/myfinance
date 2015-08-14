<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Bills;
use App\Operation;

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
        
        View::composer('layouts.main', function($view){
            $view->with('user_outomes', Operation::outcomeToday());
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
