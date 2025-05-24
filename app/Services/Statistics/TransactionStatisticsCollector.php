<?php

namespace App\Services\Statistics;

use App\Models\Support\Transaction\CashFlow;
use App\Models\Support\Transaction\Chart;
use App\Models\Support\Transaction\ChartNode;
use App\Models\Support\Transaction\Period;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class TransactionStatisticsCollector
{
    const DAYS = 31;
    
    public function collectDates(string $from, string $to): array
    {
        $period = new CarbonPeriod(
            Carbon::createFromFormat(Period::FORMAT, $from),
            new CarbonInterval('P1D'),
            Carbon::createFromFormat(Period::FORMAT, $to)
        );
        
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        
        return $dates;
    }
    
    
    /**
     * @param array $dates
     * @param Collection|Transaction[] $transactions
     * @return CashFlow
     */
    public function forCashFlow(array $dates, Collection $transactions): CashFlow
    {
        $income = $transactions->where('sign', +1)->sum(fn($transaction) => $transaction->value) * +1;
        $outcome = $transactions->where('sign', -1)->sum(fn($transaction) => $transaction->value) * -1;
        
        return new CashFlow($income, $outcome);
    }
    
    
    /**
     * @param array $dates
     * @param Collection|Transaction[] $transactions
     * @return Chart
     */
    public function forChart(array $dates, Collection $transactions): Chart
    {
        $chart = new Chart();
        
        $transactions = $transactions->where(fn($transaction) => $transaction->sign == -1)->groupBy('date');
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
     * @param Chart[] $charts
     * @return Chart
     */
    public function averageOfCharts(array $charts): Chart
    {
        $averageChart = new Chart();
        $count = count($charts);
        
        for ($i = 0; $i < static::DAYS; $i++) {
            $sum = 0;
            foreach ($charts as $chart) {
                if (!isset($chart[$i])) {
                    $sum += $chart[count($chart->nodes) - 1]->value;
                } else {
                    $sum += $chart[$i]->value;
                }
            }
            
            $averageChart[] = new ChartNode('', $sum / $count);
        }
        
        return $averageChart;
    }
}
