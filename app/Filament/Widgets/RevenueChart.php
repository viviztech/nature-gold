<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue (Last 30 Days)';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(fn ($i) => Carbon::today()->subDays($i));

        $revenue = $days->map(function ($day) {
            return Order::where('payment_status', PaymentStatus::Paid)
                ->whereDate('created_at', $day)
                ->sum('total');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (₹)',
                    'data' => $revenue->toArray(),
                    'borderColor' => '#D4A017',
                    'backgroundColor' => 'rgba(212, 160, 23, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $days->map(fn ($day) => $day->format('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
