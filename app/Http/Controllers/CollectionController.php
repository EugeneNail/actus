<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Models\Activity;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use service\CollectionServiceInterface;

class CollectionController extends Controller
{
    private CollectionServiceInterface $service;


    public function __construct(CollectionServiceInterface $service)
    {
        $this->service = $service;
    }


    public function index(): Response
    {
        return Inertia::render('Collection/Index', [
            'collections' => Auth::user()->collections()->with('activities')->get()
        ]);
    }

    public function create(): Response|RedirectResponse
    {
        if ($this->service->exceededLimit(20)) {
            return redirect(route('collections.index'));
        }

        return Inertia::render('Collection/Save');
    }


    public function store(StoreCollectionRequest $request): RedirectResponse
    {
        if ($this->service->exceededLimit(20)) {
            return back()->withErrors(['name' => 'Вы не можете иметь больше 20 коллекций.']);
        }

        if ($this->service->hasNameDuplicate($request->name)) {
            return back()->withErrors(['name' => 'У вас уже есть такая коллекция.']);
        }

        $this->service->createCollection($request->validated());

        return redirect()->intended('/collections');
    }


    public function edit(?Collection $collection): Response|RedirectResponse
    {
        $this->service->verifyOwner($collection);

        return Inertia::render('Collection/Save', [
            'id' => $collection->id,
            'name' => $collection->name,
            'color' => $collection->color,
        ]);
    }


    public function update(UpdateCollectionRequest $request, Collection $collection)
    {
        $this->service->verifyOwner($collection);

        if ($this->service->hasNameDuplicate($request->name, $collection->id)) {
            return back()->withErrors(['name' => 'У вас уже есть такая коллекция.']);
        }

        $this->service->updateCollection($collection, $request->validated());

        return redirect()->route('collections.index');
    }


    public function delete(Collection $collection): Response|RedirectResponse
    {
        $this->service->verifyOwner($collection);

        return Inertia::render('Collection/Delete', [
            'id' => $collection->id,
            'name' => $collection->name,
            'color' => $collection->color,
        ]);
    }


    public function destroy(Collection $collection): RedirectResponse
    {
        $this->service->verifyOwner($collection);
        $this->service->deleteCollection($collection);

        return redirect(route('collections.index'));
    }
}
