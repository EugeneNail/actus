<?php

namespace App\Http\Controllers;

use App\Enums\Transaction\Category;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Models\Goal;
use App\Models\Transaction;
use App\Models\User;
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


    public function delete(Transaction $transaction): Response {
        return Inertia::render('Transaction/Delete', [
            'id' => $transaction->id,
        ]);
    }


    public function destroy(Transaction $transaction): Response|RedirectResponse {
        $transaction->delete();
        return redirect()->intended(route('transactions.index'));
    }
}
