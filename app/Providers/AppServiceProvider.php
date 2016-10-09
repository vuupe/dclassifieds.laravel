<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\AdminMenu;
use App\Http\Dc\Util;
use App\Settings;
use App\Page;
use App\Banner;

use Cache;
use Validator;
use DB;
use Log;

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
        $settings = Cache::rememberForever('settings', function() {
            return Settings::all();
        });
        if(!$settings->isEmpty()){
            foreach($settings as $k => $v){
                config(['dc.' . $v->setting_name => $v->setting_value]);
            }
        }

        /**
         * Get Custom Pages From DB, Get Central Banner
         */
        view()->composer('layout.index_layout', function ($view) {
            //header menu
            $headerMenu = Cache::rememberForever('headerMenu', function() {
                return Page::select('page_title', 'page_slug')
                    ->where('page_position', Page::HEADER_MENU)
                    ->where('page_active', 1)
                    ->orderBy('page_ord', 'ASC')
                    ->get();
            });
            $view->with('headerMenu', $headerMenu);

            //footer menu
            $footerMenu = Cache::rememberForever('footerMenu', function() {
                return Page::select('page_title', 'page_slug')
                    ->where('page_position', Page::FOOTER_MENU)
                    ->where('page_active', 1)
                    ->orderBy('page_ord', 'ASC')
                    ->get();
            });
            $view->with('footerMenu', $footerMenu);

            //get central banner if any
            $today = date('Y-m-d');
            $centralBanner = Banner::where('banner_active_from', '<=' , $today)
                ->where('banner_active_to', '>=', $today)
                ->where('banner_position', Banner::BANNER_POSITION_LIST)
                ->orderByRaw('rand()')
                ->take(1)
                ->first();
            if(!empty($centralBanner)){
                $centralBanner->increment('banner_num_views');
            }
            $view->with('centralBanner', $centralBanner);
        });

        /**
         * get ad detail/ad contact banner
         */
        view()->composer(['ad.detail', 'ad.contact'], function ($view) {
            $today = date('Y-m-d');
            $adDetailBanner = Banner::where('banner_active_from', '<=' , $today)
                ->where('banner_active_to', '>=', $today)
                ->where('banner_position', Banner::BANNER_POSITION_DETAIL)
                ->orderByRaw('rand()')
                ->take(1)
                ->first();
            if(!empty($adDetailBanner)){
                $adDetailBanner->increment('banner_num_views');
            }
            $view->with('adDetailBanner', $adDetailBanner);
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
