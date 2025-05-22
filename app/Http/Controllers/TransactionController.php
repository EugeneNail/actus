<?php

namespace App\Http\Controllers;

use App\Enums\Transaction\Category;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Http\Requests\Transaction\IndexRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    private TransactionService $service;


    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }


    public function index(IndexRequest $request): Response|RedirectResponse
    {
        $periods = $this->service->collectPeriods(12);

        if ($request->missing('from') || $request->missing('to')) {
            return redirect()->route('transactions.index', [
                'from' => $periods[0]->from,
                'to' => $periods[0]->to,
            ]);
        }

        return Inertia::render('Transaction/Index', [
            'periods' => $periods,
            'transactions' => $this->service->collectTransactions($request->from, $request->to, $request->user()),
            'categories' => collect(Category::cases())->mapWithKeys(fn (Category $category) => [$category->value => new CategoryResource($category)])
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

        return redirect(route('entries.index'));
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

        return redirect(route('entries.index'));
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
}
