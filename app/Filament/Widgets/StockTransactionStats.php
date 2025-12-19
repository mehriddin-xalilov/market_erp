<?php

namespace App\Filament\Widgets;

use App\Models\StockTransaction;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StockTransactionStats extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    public ?string $filter = 'today';

    protected function getStats(): array
    {
        $cacheKey = "stock_stats_{$this->filter}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {
            [$startDate, $endDate, $previousStart, $previousEnd] = $this->getDateRange();

            // Current period stats
            $currentStats = StockTransaction::query()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('
                    type,
                    SUM(total_price) as total,
                    COUNT(*) as count
                ')
                ->groupBy('type')
                ->get()
                ->keyBy('type');

            // Previous period stats for comparison
            $previousStats = StockTransaction::query()
                ->whereBetween('created_at', [$previousStart, $previousEnd])
                ->selectRaw('
                    type,
                    SUM(total_price) as total
                ')
                ->groupBy('type')
                ->get()
                ->keyBy('type');

            $incomingTotal = $currentStats->get(1)?->total ?? 0;
            $outgoingTotal = $currentStats->get(2)?->total ?? 0;
            $profit = $incomingTotal - $outgoingTotal;

            $previousIncoming = $previousStats->get(1)?->total ?? 0;
            $previousOutgoing = $previousStats->get(2)?->total ?? 0;
            $previousProfit = $previousIncoming - $previousOutgoing;

            // Calculate percentage changes
            $incomingChange = $previousIncoming > 0
                ? (($incomingTotal - $previousIncoming) / $previousIncoming) * 100
                : 0;
            $outgoingChange = $previousOutgoing > 0
                ? (($outgoingTotal - $previousOutgoing) / $previousOutgoing) * 100
                : 0;
            $profitChange = $previousProfit != 0
                ? (($profit - $previousProfit) / abs($previousProfit)) * 100
                : 0;

            return [
                Stat::make(__('Kirimlar'), number_format($incomingTotal, 0, ',', ' ') . ' so\'m')
                    ->description($this->getChangeDescription($incomingChange))
                    ->descriptionIcon($incomingChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                    ->color($incomingChange >= 0 ? 'success' : 'danger')
                    ->chart($this->getChartData(1, $startDate, $endDate)),

                Stat::make(__('Chiqimlar'), number_format($outgoingTotal, 0, ',', ' ') . ' so\'m')
                    ->description($this->getChangeDescription($outgoingChange))
                    ->descriptionIcon($outgoingChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                    ->color($outgoingChange >= 0 ? 'danger' : 'success')
                    ->chart($this->getChartData(2, $startDate, $endDate)),

                Stat::make(__('Foyda'), number_format($profit, 0, ',', ' ') . ' so\'m')
                    ->description($this->getChangeDescription($profitChange))
                    ->descriptionIcon($profitChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                    ->color($profit >= 0 ? 'success' : 'danger')
                    ->chart($this->getProfitChartData($startDate, $endDate)),
            ];
        });
    }

    protected function getDateRange(): array
    {
        $now = Carbon::now();

        return match ($this->filter) {
            'today' => [
                $now->copy()->startOfDay(),
                $now->copy()->endOfDay(),
                $now->copy()->subDay()->startOfDay(),
                $now->copy()->subDay()->endOfDay(),
            ],
            'week' => [
                $now->copy()->startOfWeek(),
                $now->copy()->endOfWeek(),
                $now->copy()->subWeek()->startOfWeek(),
                $now->copy()->subWeek()->endOfWeek(),
            ],
            'month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth(),
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ],
            'year' => [
                $now->copy()->startOfYear(),
                $now->copy()->endOfYear(),
                $now->copy()->subYear()->startOfYear(),
                $now->copy()->subYear()->endOfYear(),
            ],
            default => [
                $now->copy()->startOfDay(),
                $now->copy()->endOfDay(),
                $now->copy()->subDay()->startOfDay(),
                $now->copy()->subDay()->endOfDay(),
            ],
        };
    }

    protected function getChangeDescription(float $change): string
    {
        $absChange = abs(round($change, 1));
        $direction = $change >= 0 ? __('o\'sish') : __('kamayish');
        return "{$absChange}% {$direction}";
    }

    protected function getChartData(int $type, Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;
        $data = [];

        for ($i = 0; $i < min($days, 7); $i++) {
            $date = $start->copy()->addDays($i);
            $total = StockTransaction::query()
                ->where('type', $type)
                ->whereDate('created_at', $date)
                ->sum('total_price');
            $data[] = $total / 1000; // Convert to thousands for better chart display
        }

        return $data;
    }

    protected function getProfitChartData(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;
        $data = [];

        for ($i = 0; $i < min($days, 7); $i++) {
            $date = $start->copy()->addDays($i);
            $incoming = StockTransaction::query()
                ->where('type', 1)
                ->whereDate('created_at', $date)
                ->sum('total_price');
            $outgoing = StockTransaction::query()
                ->where('type', 2)
                ->whereDate('created_at', $date)
                ->sum('total_price');
            $data[] = ($incoming - $outgoing) / 1000;
        }

        return $data;
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => __('Bugun'),
            'week' => __('Bu hafta'),
            'month' => __('Bu oy'),
            'year' => __('Bu yil'),
        ];
    }
}
