<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use App\AdminMenu;
use App\Http\Dc\Util;
use App\Settings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Register custom Validator
         */
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

        /**
         * Get Admin Menu from DB
         */
        view()->composer('admin.layout.admin_index_layout', function ($view) {
            $adminMenu = new AdminMenu();
            $view->with('adminMenu', $adminMenu->getMenu());
            $controller = Util::getController();
            $view->with('controller', $controller);
            $view->with('controller_parent_id', $adminMenu->getParent($controller));
        });

        /**
         * Get Settings From DB
         */
        $settings = Settings::all();
        if(!$settings->isEmpty()){
            foreach($settings as $k => $v){
                config(['dc.' . $v->setting_name => $v->setting_value]);
            }
        }

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
