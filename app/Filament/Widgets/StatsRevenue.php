<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class StatsRevenue extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';


    protected function getStats(): array
    {
        $totalRevenue = DB::table('orders')
            ->join('product_quantities', 'orders.id', '=', 'product_quantities.order_id')
            ->join('products', 'product_quantities.product_id', '=', 'products.id')
            ->where('orders.status', 'Delivered')
            ->select(DB::raw('SUM(products.price * product_quantities.quantity) as total_revenue'))
            ->first()
            ->total_revenue;


        return [
            
            Stat::make('Oders Fulfilled', Order::where('status', 'Delivered')->count())
                ->chart([0, 0, 0, 10, 15, 25, 35])
                ->color('success'),
            Stat::make('Revenue', '$' . $totalRevenue)
                ->chart([0, 1, 15, 35, 57, 267, 400])
                ->color('success'),
        ];
    }
}
