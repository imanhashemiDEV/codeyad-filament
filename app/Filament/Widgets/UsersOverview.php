<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $users_count = User::query()->count();
        $products_count = Product::query()->count();
        return [
            Stat::make('تعداد کاربران', $users_count)
                ->description('my customers')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('تعداد محصولات', $products_count)
                ->description('my products')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
        ];
    }
}
