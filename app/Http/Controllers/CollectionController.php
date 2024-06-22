<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CollectionController extends Controller
{
    public function index(): Response {
        return Inertia::render('Collection/Index');
    }

    public function create(): Response | RedirectResponse
    {
        if (Auth::user()->collections->count() >= 20) {
            return redirect(route('collections.index'));
        }

        return Inertia::render('Collection/Save');
    }


    public function store(StoreCollectionRequest $request): RedirectResponse {
        if (Auth::user()->collections->count() >= 20) {
            return back()->withErrors(['name' => 'Вы не можете иметь больше 20 коллекций.']);
        }

        $collection = new Collection($request->validated());
        Auth::user()->collections()->save($collection);
        $collection->save();

        return redirect()->intended('/collections');
    }
}
