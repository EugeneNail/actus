<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CollectionController extends Controller
{
    public function index(): Response {
        return Inertia::render('Collection/Index');
    }

    public function create(): Response
    {
        return Inertia::render('Collection/Save');
    }


    public function store(StoreCollectionRequest $request): RedirectResponse {
        $collection = new Collection($request->validated());
        Auth::user()->collections()->save($collection);
        $collection->save();

        return redirect()->intended('/collections');
    }




}
