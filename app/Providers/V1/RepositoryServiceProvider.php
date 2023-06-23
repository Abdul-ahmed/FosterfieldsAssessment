<?php

namespace App\Providers\V1;

use App\Repositories\V1\TransactionRepository;
use App\Repositories\V1\UserRepository;
use App\Repositories\V1\WalletRepository;
use App\Repositories\V1\WalletTypeRepository;
use App\Services\V1\TransactionService;
use App\Services\V1\UserService;
use App\Services\V1\WalletService;
use App\Services\V1\WalletTypeService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            UserService::class
        );

        $this->app->bind(
            WalletTypeRepository::class,
            WalletTypeService::class
        );

        $this->app->bind(
            WalletRepository::class,
            WalletService::class
        );

        $this->app->bind(
            TransactionRepository::class,
            TransactionService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
