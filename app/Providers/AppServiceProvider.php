<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Providers;

use App\Http\Contracts\ITransactionHistoryServiceContract;
use App\Http\Contracts\IWalletServiceContract;
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

        $this->app->singleton(ITransactionHistoryServiceContract::class, function ($app) {
            return $app->make(TransactionHistoryService::class);
        });

        $this->app->singleton(IWalletServiceContract::class, function ($app) {
            return $app->make(WalletService::class);
        });
    }
}
