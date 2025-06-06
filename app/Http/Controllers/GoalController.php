<?php

namespace App\Http\Controllers;

use App\Http\Requests\Goals\StoreRequest;
use App\Http\Requests\Goals\UpdateRequest;
use App\Models\Goal;
use App\Services\GoalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GoalController extends Controller
{
    private GoalService $service;
    
    
    public function __construct(GoalService $service)
    {
        $this->service = $service;
    }
    
    
    public function index(): Response|RedirectResponse
    {
        return Inertia::render('Goal/Index', [
            'goals' => Auth::user()->goals()->get()
        ]);
    }
    
    
    public function create(): Response|RedirectResponse
    {
        return Inertia::render('Goal/Save');
    }
    
    
    public function store(StoreRequest $request): Response|RedirectResponse
    {
        $this->service->create($request->validated());
        return redirect()->intended(route('goals.index'));
    }
    
    
    public function edit(Goal $goal): Response|RedirectResponse
    {
        return Inertia::render('Goal/Save', [
            'goal' => $goal
        ]);
    }
    
    
    public function update(UpdateRequest $request, Goal $goal): Response|RedirectResponse
    {
        $this->service->update($goal, $request->validated());
        return redirect()->intended(route('goals.index'));
    }
    
    
    public function delete(Goal $goal): Response
    {
        return Inertia::render('Goal/Delete', [
            'name' => $goal->name,
            'id' => $goal->id,
        ]);
    }
    
    
    public function destroy(Goal $goal): Response|RedirectResponse
    {
        $this->service->delete($goal);
        return redirect()->intended(route('goals.index'));
    }
}
