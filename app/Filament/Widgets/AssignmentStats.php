<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class AssignmentStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Assignments', Assignment::count())
                ->description('Lahat ng assignments')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary'),

            Stat::make('To Do', Assignment::where('status', 'pending')->count())
                ->description('Hindi pa nasisimulan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),

            Stat::make('Due This Week', Assignment::whereBetween('due_date', [Carbon::now(), Carbon::now()->endOfWeek()])->count())
                ->description('Due before weekend')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),

            Stat::make('Finished', Assignment::where('status', 'done')->count())
                ->description('Tapos na')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}