<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CollectionController extends Controller
{
    public function index(): Response {
        return Inertia::render('Collection/Index', [
            'collections' => Auth::user()->collections
        ]);
    }

    public function create(): Response | RedirectResponse
    {
        if (Auth::user()->collections->count() >= 20) {
            return redirect(route('collections.index'));
        }

        return Inertia::render('Collection/Save');
    }


    public function store(StoreCollectionRequest $request): RedirectResponse {
        $user = Auth::user();
        if ($user->collections->count() >= 20) {
            return back()->withErrors(['name' => 'Вы не можете иметь больше 20 коллекций.']);
        }

        $hasDuplicate = $user->collections->where('name', $request->name)->count() > 0;
        if ($hasDuplicate) {
            return back()->withErrors(['name' => 'У вас уже есть такая коллекция.']);
        }

        $collection = new Collection($request->validated());
        Auth::user()->collections()->save($collection);
        $collection->save();

        return redirect()->intended('/collections');
    }


    public function edit(?Collection $collection): Response | RedirectResponse {
        if ($collection->user_id != Auth::user()->id) {
            abort(404);
        }

        return Inertia::render('Collection/Save', [
            'id' => $collection->id,
            'name' => $collection->name,
            'color' => $collection->color,
        ]);
    }


    public function update(UpdateCollectionRequest $request, Collection $collection) {
        $user = Auth::user();
        if ($collection->user_id != $user->id) {
            abort(404);
        }

        $hasDuplicate = $user->collections->where('name', $request->name)->where('id', '!=', $collection->id)->count() > 0;
        if ($hasDuplicate) {
            return back()->withErrors(['name' => 'У вас уже есть такая коллекция.']);
        }

        $collection->update($request->validated());

        return redirect()->route('collections.index');
    }


    public function delete(Collection $collection): Response | RedirectResponse {
        if ($collection->user_id != Auth::user()->id) {
            abort(404);
        }

        return Inertia::render('Collection/Delete', [
            'id' => $collection->id,
            'name' => $collection->name,
            'color' => $collection->color,
        ]);
    }


    public function destroy(Collection $collection): RedirectResponse {
        if ($collection->user_id != Auth::user()->id) {
            abort(404);
        }

        $collection->delete();

        return redirect(route('collections.index'));
    }
}
