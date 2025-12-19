<?php

namespace App\Filament\Widgets;

use App\Models\StockTransaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class StockTransactionChart extends ChartWidget
{
    protected ?string $heading = 'Kirim va Chiqim Grafigi';

//    protected  $columnSpan = 'full';

    public ?string $filter = 'week';

    protected function getData(): array
    {
        $cacheKey = "stock_chart_{$this->filter}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            [$labels, $incomingData, $outgoingData] = $this->getChartData();

            return [
                'datasets' => [
                    [
                        'label' => __('Kirimlar'),
                        'data' => $incomingData,
                        'borderColor' => 'rgb(34, 197, 94)',
                        'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                        'fill' => true,
                    ],
                    [
                        'label' => __('Chiqimlar'),
                        'data' => $outgoingData,
                        'borderColor' => 'rgb(239, 68, 68)',
                        'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                        'fill' => true,
                    ],
                ],
                'labels' => $labels,
            ];
        });
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Summa (ming so\'m)',
                    ],
                    'beginAtZero' => true,
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Sana',
                    ],
                ],
            ],
        ];
    }

    protected function getChartData(): array
    {
        $now = Carbon::now();
        $labels = [];
        $incomingData = [];
        $outgoingData = [];

        match ($this->filter) {
            'week' => $this->getWeeklyData($now, $labels, $incomingData, $outgoingData),
            'month' => $this->getMonthlyData($now, $labels, $incomingData, $outgoingData),
            'year' => $this->getYearlyData($now, $labels, $incomingData, $outgoingData),
            default => $this->getWeeklyData($now, $labels, $incomingData, $outgoingData),
        };

        return [$labels, $incomingData, $outgoingData];
    }

    protected function getWeeklyData(Carbon $now, array &$labels, array &$incomingData, array &$outgoingData): void
    {
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $labels[] = $date->format('D');

            $incoming = StockTransaction::query()
                ->where('type', 1)
                ->whereDate('created_at', $date)
                ->sum('total_price');

            $outgoing = StockTransaction::query()
                ->where('type', 2)
                ->whereDate('created_at', $date)
                ->sum('total_price');

            $incomingData[] = $incoming / 1000;
            $outgoingData[] = $outgoing / 1000;
        }
    }

    protected function getMonthlyData(Carbon $now, array &$labels, array &$incomingData, array &$outgoingData): void
    {
        for ($i = 29; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $labels[] = $date->format('d');

            $incoming = StockTransaction::query()
                ->where('type', 1)
                ->whereDate('created_at', $date)
                ->sum('total_price');

            $outgoing = StockTransaction::query()
                ->where('type', 2)
                ->whereDate('created_at', $date)
                ->sum('total_price');

            $incomingData[] = $incoming / 1000;
            $outgoingData[] = $outgoing / 1000;
        }
    }

    protected function getYearlyData(Carbon $now, array &$labels, array &$incomingData, array &$outgoingData): void
    {
        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $labels[] = $date->format('M');

            $incoming = StockTransaction::query()
                ->where('type', 1)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');

            $outgoing = StockTransaction::query()
                ->where('type', 2)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');

            $incomingData[] = $incoming / 1000;
            $outgoingData[] = $outgoing / 1000;
        }
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => __('Oxirgi 7 kun'),
            'month' => __('Oxirgi 30 kun'),
            'year' => __('Oxirgi 12 oy'),
        ];
    }
}
