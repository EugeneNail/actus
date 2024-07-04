<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use App\Models\Activity;
use App\Models\Collection;
use App\Services\ActivityServiceInterface;
use App\Services\CollectionServiceInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

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


    public function delete(Collection $collection, Activity $activity): Response {
        $this->collectionService->verifyOwner($collection);
        $this->activityService->verifyOwner($activity);

        return Inertia::render('Activity/Delete', [
            'activityName' => $activity->name,
            'activityId' => $activity->id,
            'collectionId' => $collection->id,
            'color' => $collection->color,
        ]);
    }


    public function destroy(Collection $collection, Activity $activity): RedirectResponse {
        $this->collectionService->verifyOwner($collection);
        $this->activityService->verifyOwner($activity);
        $this->activityService->destroy($activity);

        return redirect(route('collections.index'));
    }
}
