<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use App\AdminMenu;
use App\Http\Dc\Util;

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
    	
    	view()->composer('admin.layout.admin_index_layout', function ($view) {
    		$adminMenu = new AdminMenu();
            $view->with('adminMenu', $adminMenu->getMenu());
            $view->with('controller', Util::getController());
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
