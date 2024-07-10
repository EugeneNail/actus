<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entry\IndexRequest;
use App\Http\Requests\Entry\StoreRequest;
use App\Http\Requests\Entry\UpdateRequest;
use App\Models\Entry;
use App\Services\Activity\ActivityServiceInterface;
use App\Services\Entry\EntryServiceInterface;
use App\Services\Photo\PhotoServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    private EntryServiceInterface $entryService;

    private ActivityServiceInterface $activityService;

    private PhotoServiceInterface $photoService;


    public function __construct(EntryServiceInterface $entryService, ActivityServiceInterface $activityService, PhotoServiceInterface $photoService)
    {
        $this->entryService = $entryService;
        $this->activityService = $activityService;
        $this->photoService = $photoService;
    }


    public function index(IndexRequest $request): Response
    {
        $months = Auth::user()
            ->entries
            ->map(fn($entry) => ['date' => $entry->date->format("Y-m")])
            ->groupBy('date')
            ->map(function ($group, $key) {
                $carbon = Carbon::createFromFormat('Y-m', $key);

                return [
                    'entries' => count($group),
                    'days' => $carbon->daysInMonth,
                    'month' => $carbon->month,
                    'year' => $carbon->year,
                ];
            })
            ->sortByDesc(['year', 'month'])
            ->values();

        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        return Inertia::render('Entry/Index', [
            'entries' => $this->entryService->collectForIndex($month, $year),
            'months' => $months,
        ]);
    }


    public function create(): Response
    {
        return Inertia::render("Entry/Save", [
            'entry' => [],
            'collections' => Auth::user()->collections()->with("activities")->get(),
        ]);
    }


    public function store(StoreRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($this->entryService->existsForDate($request->date, $user->id)) {
            return back()->withErrors(['date' => 'У вас уже есть запись на эту дату.']);
        }

        $areRelationsValid =
            $this->activityService->allExist($request->activities)
            && $this->activityService->ownsEach($request->activities, $user->id)
            && $this->photoService->allExist($request->photos)
            && $this->photoService->ownsEach($request->photos, $user->id);
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entryService->create($request->validated(), $user->id);
        $this->entryService->saveActivities($entry, $request->activities);
        $this->entryService->savePhotos($entry, $request->photos);

        return redirect(route('entries.index'));
    }


    public function edit(Entry $entry): Response
    {
        return Inertia::render("Entry/Save", [
            'entry' => [
                'id' => $entry->id,
                'date' => $entry->date,
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'diary' => $entry->diary,
                'activities' => $entry->activities->map(fn($activity) => $activity->id),
                'photos' => $entry->photos->map(fn ($photo) => $photo->name)
            ],
            'collections' => Auth::user()->collections()->with("activities")->get(),
        ]);
    }


    public function update(UpdateRequest $request, Entry $entry): RedirectResponse
    {
        $user = $request->user();

        $areRelationsValid =
            $this->activityService->allExist($request->activities)
            && $this->activityService->ownsEach($request->activities, $user->id)
            && $this->photoService->allExist($request->photos)
            && $this->photoService->ownsEach($request->photos, $user->id);
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entryService->update($entry, $request->validated());
        $this->entryService->saveActivities($entry, $request->activities);
        $this->entryService->savePhotos($entry, $request->photos);

        return redirect(route('entries.index'));
    }
}
