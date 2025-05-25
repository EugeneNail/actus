<?php

namespace App\Services\Statistics;

use App\Models\Support\Transaction\Flow;
use App\Models\Support\Transaction\Chart;
use App\Models\Support\Transaction\ChartNode;
use App\Models\Support\Transaction\Period;
use App\Services\Dates;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TransactionStatisticsCollector
{
    private const DAYS = 31;
    
    
    /**
     * Aggregates main and compared charts.
     * The compared chart is aggregated as the average value of latest months
     * @param array $dates
     * @param Collection $transactions
     * @param int $months
     * @return array{Chart, Chart, float}
     */
    public function forChart(array $dates, Collection $transactions, int $months = 3): array
    {
        $flowTransactions = $transactions->whereIn('date', $dates);
        $flow = new Flow(
            $flowTransactions->where('sign', +1)->sum(fn($transaction) => $transaction->value),
            $flowTransactions->where('sign', -1)->sum(fn($transaction) => $transaction->value)
        );
        
        $periods = $this->collectPeriods(4);
        $transactions = $transactions->where(fn($transaction) => $transaction->sign == -1);
        
        $mainChart = $this->aggregateChart($dates, $transactions);
        $comparedChart = $this->aggregateAverageChart($periods, $transactions, $months);
        
        $max = max($mainChart->max(), $comparedChart->max());
        $mainChart->calculatePercents($max);
        $comparedChart->calculatePercents($max);
        
        return [
            'flow' => $flow,
            'scales' => Chart::extractScales($max),
            'main' => $mainChart,
            'compared' => $comparedChart
        ];
    }
    
    
    /**
     * Aggregates cumulative chart from transactions
     * @param array $dates
     * @param Collection $transactions
     * @return Chart
     */
    private function aggregateChart(array $dates, Collection $transactions): Chart
    {
        $chart = new Chart();
        
        $transactions = $transactions->groupBy('date');
        $latestDate = array_key_first($transactions->toArray());
        $cumulativeSum = 0;
        
        foreach ($dates as $date) {
            if (!isset($transactions[$date])) {
                if ($date < $latestDate) {
                    $chart[] = new ChartNode($date, $cumulativeSum);
                }
                continue;
            }
            
            foreach ($transactions[$date] as $transaction) {
                $cumulativeSum += $transaction->value;
            }
            
            $chart[] = new ChartNode($date, $cumulativeSum);
        }
        
        return $chart;
    }
    
    
    /**
     * Aggregates the average value of latest months
     * @param Period[] $periods
     * @param Collection $transactions
     * @param int $months
     * @return Chart
     */
    private function aggregateAverageChart(array $periods, Collection $transactions, int $months = 3): Chart
    {
        $charts = [];
        for ($i = 1; $i <= $months; $i++) {
            $dates = Dates::collect($periods[$i]->from, $periods[$i]->to, Period::FORMAT);
            $charts[] = $this->aggregateChart($dates, $transactions);
        }
        
        $comparedChart = new Chart();
        
        for ($i = 0; $i < static::DAYS; $i++) {
            $sum = 0;
            foreach ($charts as $chart) {
                $sum += isset($chart[$i])
                    ? $chart[$i]->value
                    : $chart[array_key_last($chart->nodes)]->value ?? 0;
            }
            
            $comparedChart[] = new ChartNode('', $sum / $months);
        }
        
        return $comparedChart;
    }
    
    
    /**
     * Maps last $monthCount months into array of ['from' => 05/m/Y, 'to' => 04/m/Y] objects
     * @param int $monthCount
     * @return Period[]
     */
    public function collectPeriods(int $monthCount): array
    {
        $periods = [];
        for ($i = 0; $i < $monthCount; $i++) {
            $current = (new Carbon())->subMonths($i);
            
            $periods[] = new Period(
                $current->clone()->startOfMonth()->addDays(4),
                $current->clone()->startOfMonth()->addMonth()->addDays(3),
            );
        }
        
        return $periods;
    }
}
