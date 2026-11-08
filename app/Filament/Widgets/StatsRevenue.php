<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Support\Money;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsRevenue extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalRevenue = DB::table('orders')
            ->join('product_quantities', 'orders.id', '=', 'product_quantities.order_id')
            ->where('orders.status', OrderStatus::Delivered)
            ->sum(DB::raw('product_quantities.unit_price * product_quantities.quantity'));

        return [

            Stat::make('Orders Fulfilled', Order::where('status', OrderStatus::Delivered)->count())
                ->chart([0, 0, 0, 10, 15, 25, 35])
                ->color('success'),
            Stat::make('Revenue', Money::format($totalRevenue))
                ->chart([0, 1, 15, 35, 57, 267, 400])
                ->color('success'),
        ];
    }
}
