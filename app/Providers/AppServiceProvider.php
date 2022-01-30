<?php

namespace App\Providers;

use App\Contracts\CartRepositoryInterface;
use App\Contracts\CartServiceInterface;
use App\Contracts\PurchaseServiceInterface;
use App\Contracts\SaleRepositoryInterface;
use App\Contracts\StockRepositoryInterface;
use App\Contracts\StockServiceInterface;
use App\Contracts\WatchRepositoryInterface;
use App\Contracts\WatchServiceInterface;
use App\Repositories\CartRepository;
use App\Repositories\SaleRepository;
use App\Repositories\StockRepository;
use App\Repositories\WatchRepository;
use App\Services\CartService;
use App\Services\PurchaseService;
use App\Services\StockService;
use App\Services\WatchService;
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
        $this->app->bind(WatchRepositoryInterface::class, WatchRepository::class);
        $this->app->bind(WatchServiceInterface::class, WatchService::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(PurchaseServiceInterface::class, PurchaseService::class);
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
        $this->app->bind(StockServiceInterface::class, StockService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
