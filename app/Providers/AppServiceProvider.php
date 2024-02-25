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

        Paginator::useBootstrapFour();
    }
}
