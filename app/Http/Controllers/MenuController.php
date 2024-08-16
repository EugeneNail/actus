<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(Request $request): Response {
        $user = $request->user();
        return Inertia::render('Menu/Menu', [
            'user' => [
                'name' => $user->name,
                'id' => $user->id
            ],
            'counters' => [
                'records' => $user->entries->count(),
                'photos' => $user->photos->count()
            ]
        ]);
    }
}
