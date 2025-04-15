<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use DateTime;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Menu/Menu', [
            'user' => [
                'name' => $user->name,
                'id' => $user->id
            ],
            'counters' => [
                'records' => $user->entries->count(),
                'photos' => $user->photos->count()
            ],
            'exportPeriods' => [
                'diaries' => $user->entries
                    ->where('diary', '!=', '')
                    ->sortByDesc('date')
                    ->map(fn(Entry $entry) => substr($entry->date, 0, 4))
                    ->unique()
                    ->values(),
                'photos' => $user->entries()
                    ->orderByDesc('date')
                    ->whereHas('photos')
                    ->get('date')
                    ->map(fn(Entry $entry) => new DateTime($entry->date))
                    ->map(fn(DateTime $date) => ['year' => $date->format('Y'), 'month' => $date->format('m')])
                    ->unique(fn($date) => $date['year'] . '.' . $date['month'])
                    ->values()
            ]
        ]);
    }
}
