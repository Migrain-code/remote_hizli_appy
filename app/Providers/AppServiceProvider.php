<?php

namespace App\Providers;

use App\Core\CustomResourceRegistrar;
use App\Models\Business;
use App\Models\BusinessInfo;
use App\Models\Category;
use App\Models\City;
use App\Models\ForBusiness;
use App\Models\Page;
use App\Models\ServiceCategory;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application service.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application service.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        $registrar = new CustomResourceRegistrar($this->app['router']);

        $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
            return $registrar;
        });
        $request = Request::instance();
        if (!$request->is('api/*')) {
            $settings = [];

            foreach (Setting::all() as $item) {
                $settings[$item->name] = $item->value;
            }
            $sections = [];
            foreach (ForBusiness::all() as $item) {
                $sections[$item->name] = $item->value;
            }
            \Config::set('sections', $sections);
            \Config::set('settings', $settings);
            $globalData = [
                'pages' => Page::where('status', 1)->take(5)->latest()->get(),
                'infos' => BusinessInfo::where('status', 0)->get(),
            ];

            \View::share('globalData', $globalData);
            $cities = City::orderBy('name')->get();
            View::share('cities', $cities);
            $businesses = Business::all();
            View::share('businesses', $businesses);
            $services = ServiceCategory::all();
            View::share('services_top', $services);
            $categorys = Category::all();
            View::share('categories', $categorys);
        }

        Paginator::useBootstrapFour();
    }
}
