<?php

namespace App\Http\Controllers;

use App\Enums\Transaction\Category;
use App\Http\Requests\Transaction\IndexRequest;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Support\Transaction\Chart;
use App\Models\Transaction;
use App\Services\Statistics\TransactionStatisticsCollector;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    private TransactionService $service;
    
    private TransactionStatisticsCollector $statistics;
    
    
    public function __construct(
        TransactionService $service,
        TransactionStatisticsCollector $statisticsCollector
    ) {
        $this->service = $service;
        $this->statistics = $statisticsCollector;
    }
    
    
    public function index(IndexRequest $request): Response|RedirectResponse
    {
        $periods = $this->service->collectPeriods(12);
        
        if (!$request->from || !$request->to) {
            return redirect()->route('transactions.index', [
                'from' => $periods[0]->from,
                'to' => $periods[0]->to,
            ]);
        }
        
        $user = $request->user();
        $transactions = $user->transactions()->get();
        $dates = $this->statistics->collectDates($request->from, $request->to);
        $mainChart = $this->statistics->forChart($dates, $transactions);
        
        $chartsToAggregate = [];
        for ($i = 1; $i <= 3; $i++) {
            $dates = $this->statistics->collectDates($periods[$i]->from, $periods[$i]->to);
            $chartsToAggregate[] = $this->statistics->forChart($dates, $transactions);
        }
        
        $comparedChart = $this->statistics->averageOfCharts($chartsToAggregate);
        $max = max($mainChart->max(), $comparedChart->max());
        $mainChart->calculatePercents($max);
        $comparedChart->calculatePercents($max);
        
        return Inertia::render('Transaction/Index', [
            'periods' => $periods,
            'categories' => collect(Category::cases())->mapWithKeys(fn(Category $category) => [$category->value => new CategoryResource($category)]),
            'transactions' => $this->service->collectDateTransactions($request->from, $request->to, $request->user()),
            'cashFlow' => $this->statistics->forCashFlow($dates, $transactions),
            'chart' => [
                'scales' => Chart::extractScales($max),
                'main' => $mainChart,
                'compared' => $comparedChart
            ]
        ]);
    }
    
    
    public function create(): Response
    {
        $transaction = new Transaction([
            'date' => date('Y-m-d'),
            'value' => 0,
            'category' => Category::BILLS,
            'sign' => -1,
            'description' => '',
        ]);
        $transaction->id = 0;
        
        return Inertia::render('Transaction/Save', [
            'transaction' => $transaction,
            'categories' => $this->service->categoriesToList()
        ]);
    }
    
    
    public function store(StoreRequest $request): Response|RedirectResponse
    {
        $transaction = new Transaction($request->validated());
        $request->user()->transactions()->save($transaction);
        
        return redirect(route('transactions.index'));
    }
    
    
    public function edit(Transaction $transaction): Response
    {
        return Inertia::render('Transaction/Save', [
            'transaction' => $transaction,
            'categories' => $this->service->categoriesToList()
        ]);
    }
    
    
    public function update(UpdateRequest $request, Transaction $transaction): Response|RedirectResponse
    {
        $transaction->fill($request->validated());
        $transaction->save();
        
        return redirect(route('transactions.index'));
    }
    
    
    public function delete(Transaction $transaction): Response
    {
        return Inertia::render('Transaction/Delete', [
            'id' => $transaction->id,
        ]);
    }
    
    
    public function destroy(Transaction $transaction): Response|RedirectResponse
    {
        $transaction->delete();
        return redirect()->intended(route('transactions.index'));
    }
    
    
    public function statistics(): Response
    {
        return Inertia::render('Transaction/Statistics', [
            'incomes' => $incomes,
            'outcomes' => $outcomes,
            'total' => $incomes + $outcomes
        ]);
    }
}
