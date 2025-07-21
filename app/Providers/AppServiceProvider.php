<?php

namespace App\Providers;

use App\CostCenterType;
use App\Currency;
use App\Models\MstACType;
use App\Models\MstDefinition;
use App\VatRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        // Custom blade directive for role check
        Blade::if('role', function ($role) {
            return Auth::user()->role->slug == $role;
        });

        $standard_vat_rate=VatRate::find(1)->value;
        view()->share('standard_vat_rate', $standard_vat_rate);
        view()->composer('*', function ($view) {
            $currency = Currency::find(1);
            $view->with('currency', $currency);
        });
        $partyTypes=CostCenterType::get();
        view()->share('partyTypes',$partyTypes);
    }
}
