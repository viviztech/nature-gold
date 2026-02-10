<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Orders by Status';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = collect(OrderStatus::cases())->map(function ($status) {
            return Order::where('status', $status)->count();
        });

        return [
            'datasets' => [
                [
                    'data' => $data->toArray(),
                    'backgroundColor' => [
                        '#f59e0b', // pending - warning
                        '#3b82f6', // confirmed - info
                        '#D4A017', // processing - gold
                        '#6366f1', // shipped - indigo
                        '#22c55e', // delivered - success
                        '#ef4444', // cancelled - danger
                        '#9ca3af', // returned - gray
                    ],
                ],
            ],
            'labels' => collect(OrderStatus::cases())->map(fn ($s) => $s->label())->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
