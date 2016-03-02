<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	Validator::extend('require_one_of_array', function($attribute, $value, $parameters, $validator) {
    		if(!is_array($value)){
    			return false;
    		}
    		
    		foreach ($value as $k => $v){
    			if(!empty($v)){
    				return true;
    			}
    		}
    		
    		return false;
    	});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
