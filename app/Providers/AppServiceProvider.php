<?php

namespace App\Providers;

use App\Http\Controllers\Setting\CompanySettingController;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\CompanySettingTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use CompanySettingTrait;
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
        //
        view()->composer('*', function ($view)
        {
            if(Auth::user()) {
                $company = $this->getCompanyDetails(Auth::user()->id);
                //...with this variable
                $view->with('company_account_details', $company);
            }
        });
        Schema::defaultStringLength(191);
    }
}
