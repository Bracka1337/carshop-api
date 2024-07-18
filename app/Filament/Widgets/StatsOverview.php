<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Users Registered', User::count('id'))
                ->chart([3, 9, 16, 26, 35, 60, 70])
                ->color('success'),
            Stat::make('Orders Created', Order::count('id'))
                ->chart([0, 96, 15, 20, 40, 130, 170])
                ->color('success'),
        ];
    }
}
