<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Providers;

use App\Http\Contracts\IBlogContract;
use App\Http\Contracts\ISubordinateContract;
use App\Http\Contracts\ITransactionHistoryServiceContract;
use App\Http\Contracts\IWalletServiceContract;
use App\Http\Services\BlogService;
use App\Http\Services\SubordinateService;
use App\Http\Services\TransactionHistoryService;
use App\Http\Services\UserService;
use App\Http\Services\WalletService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\IUserServiceContract;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
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
        Schema::defaultStringLength(191);

        $this->app->singleton(IUserServiceContract::class, function ($app) {
            return $app->make(UserService::class);
        });

        $this->app->singleton(ISubordinateContract::class, function ($app) {
            return $app->make(SubordinateService::class);
        });

        $this->app->singleton(IBlogContract::class, function ($app) {
            return $app->make(BlogService::class);
        });
    }
}
