<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activity\StoreRequest;
use App\Models\Activity;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use service\CollectionServiceInterface;

class ActivityController extends Controller
{
    private CollectionServiceInterface $collectionService;

    public function __construct(CollectionServiceInterface $collectionService)
    {
        $this->collectionService = $collectionService;
    }


    public function create(Collection $collection): Response {
        $this->collectionService->verifyOwner($collection);

        return Inertia::render('Activity/Save', [
            'collection' => $collection
        ]);
    }


    public function store(Collection $collection, StoreRequest $request): RedirectResponse {
        $this->collectionService->verifyOwner($collection);

        $activity = new Activity($request->validated());
        $activity->user()->associate(Auth::user());
        $activity->collection()->associate($collection);
        $activity->save();

        return redirect(route('collections.index'));
    }
}
