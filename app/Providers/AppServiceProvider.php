<?php

namespace App\Providers;

use App\Http\Contracts\ITransactionHistoryServiceContract;
use App\Http\Services\TransactionHistoryService;
use App\Http\Services\UserService;
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
    }
}
