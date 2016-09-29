<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Bills;
use App\Operation;
use App\Category;

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
            $view->with('user_ouctomes', Operation::outcomeToday());
        });
		
		View::composer('layouts.main', function($view){
            $view->with('today',date('Y-m-d H:i', time()));
        });
		
		View::composer('layouts.main', function($view){
            $view->with('bills',Bills::userBills());
        });
		
		View::composer('layouts.main', function($view){
            $view->with('categories', Category::getCategories());
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
