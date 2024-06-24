<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use App\Models\Activity;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use service\ActivityServiceInterface;
use service\CollectionServiceInterface;

class ActivityController extends Controller
{
    private CollectionServiceInterface $collectionService;
    private ActivityServiceInterface $activityService;

    public function __construct(CollectionServiceInterface $collectionService, ActivityServiceInterface $activityService)
    {
        $this->collectionService = $collectionService;
        $this->activityService = $activityService;
    }


    public function create(Collection $collection): Response {
        $this->collectionService->verifyOwner($collection);

        return Inertia::render('Activity/Save', [
            'collection' => $collection
        ]);
    }


    public function store(Collection $collection, StoreRequest $request): RedirectResponse {
        $this->collectionService->verifyOwner($collection);

        if ($this->activityService->exceededLimit(20, $collection)) {
            return back()->withErrors(['name' => 'Вы не можете иметь больше 20 активностей в этой коллекции.']);
        }

        if ($this->activityService->hasNameDuplicate($request->name, $collection)) {
            return back()->withErrors(['name' => 'У вас уже есть такая активность в этой коллекции.']);
        }

        $this->activityService->create($collection, $request->validated());

        return redirect()->intended(route('collections.index'));
    }


    public function edit(Collection $collection, Activity $activity) {
        $this->collectionService->verifyOwner($collection);
        $this->activityService->verifyOwner($activity);

        return Inertia::render('Activity/Save', [
            'collection' => $collection,
            'activity' => $activity,
        ]);
    }


    public function update(UpdateRequest $request, Collection $collection, Activity $activity): RedirectResponse {
        $this->collectionService->verifyOwner($collection);
        $this->activityService->verifyOwner($activity);

        if ($this->activityService->hasNameDuplicate($request->name, $collection, $activity->id)) {
            return back()->withErrors(['name' => 'У вас уже есть такая активность в этой коллекции.']);
        }

        $this->activityService->update($activity, $request->validated());

        return redirect()->intended(route('collections.index'));
    }
}
