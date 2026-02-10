<?php

namespace App\Filament\Widgets;

use App\Enums\DealerStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayRevenue = Order::where('payment_status', PaymentStatus::Paid)
            ->whereDate('created_at', today())
            ->sum('total');

        $monthRevenue = Order::where('payment_status', PaymentStatus::Paid)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $pendingOrders = Order::where('status', OrderStatus::Pending)->count();

        $totalCustomers = User::where('role', 'customer')->count();

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('is_active', true)
            ->count();

        $pendingDealers = \App\Models\Dealer::where('status', DealerStatus::Pending)->count();

        return [
            Stat::make('Today\'s Revenue', '₹' . number_format($todayRevenue, 2))
                ->description('Month: ₹' . number_format($monthRevenue, 2))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Needs attention')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),

            Stat::make('Total Customers', $totalCustomers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Low Stock Products', $lowStockProducts)
                ->description('Stock ≤ 10 units')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockProducts > 0 ? 'danger' : 'success'),
        ];
    }
}
