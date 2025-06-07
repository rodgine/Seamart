<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\CustomerDetail;
use App\Models\Product;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('layouts.admin', function ($view) {
            $pendingOrdersCount = Order::where('status', 'pending')->count();
            $customerCount = CustomerDetail::whereDate('created_at', today())->count(); 
            $lowStockCount = Product::where('stock', '<', 10)
                ->where('stock', '!=', 0)
                ->count();
            $noStockCount = Product::where('stock', '=', 0)->count();

            $totalNotifications = 0;

            if ($pendingOrdersCount > 0) $totalNotifications++;
            if ($customerCount > 0) $totalNotifications++;
            if ($lowStockCount > 0) $totalNotifications++;
            if ($noStockCount > 0) $totalNotifications++;

            $view->with(compact(
                'pendingOrdersCount',
                'customerCount',
                'lowStockCount',
                'noStockCount',
                'totalNotifications'
            ));
        });
    }
}
