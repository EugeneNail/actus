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
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    private EntryServiceInterface $entries;

    private ActivityServiceInterface $activities;

    private PhotoServiceInterface $photos;


    public function __construct(EntryServiceInterface $entryService, ActivityServiceInterface $activityService, PhotoServiceInterface $photoService)
    {
        $this->entries = $entryService;
        $this->activities = $activityService;
        $this->photos = $photoService;
    }


    public function index(IndexRequest $request): Response | RedirectResponse
    {
        if ($request->missing('month') || $request->missing('year')) {
            return redirect()->route('entries.index', [
                'month' => (int)date('m'),
                'year' => date('Y')
            ]);
        }

        return Inertia::render('Entry/Index', [
            'entries' => $this->entries->collectForIndex($request->month, $request->year),
            'months' => $this->entries->collectMonthData($request->user()),
        ]);
    }


    public function create(): Response
    {
        return Inertia::render("Entry/Save", [
            'entry' => [
                'goals' => Auth::user()->goals,
                'completedGoals' => [],
            ],
            'collections' => Auth::user()->collections()->with("activities")->get(),
        ]);
    }


    public function store(StoreRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($this->entries->existsForDate($request->date, $user->id)) {
            return back()->withErrors(['date' => 'У вас уже есть запись на эту дату.']);
        }

        $areRelationsValid =
            $this->activities->allExist($request->activities)
            && $this->activities->ownsEach($request->activities, $user->id)
            && $this->photos->allExist($request->photos)
            && $this->photos->ownsEach($request->photos, $user->id);
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entries->create($request->validated(), $user->id);
        $this->entries->saveActivities($entry, $request->activities);
        $this->entries->savePhotos($entry, $request->photos);
        $this->entries->saveGoals($entry, $request->completedGoals);

        return redirect(route('entries.index'));
    }


    public function edit(Entry $entry): Response
    {
        return Inertia::render("Entry/Save", [
            'entry' => [
                'id' => $entry->id,
                'date' => $entry->date,
                'completedGoals' => $entry->goals->map(fn ($goal) => $goal->id),
                'goals' => Auth::user()->goals,
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'sleeptime' => $entry->sleeptime,
                'weight' => $entry->weight,
                'worktime' => $entry->worktime,
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
            $this->activities->allExist($request->activities)
            && $this->activities->ownsEach($request->activities, $user->id)
            && $this->photos->allExist($request->photos)
            && $this->photos->ownsEach($request->photos, $user->id);
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entries->update($entry, $request->validated());
        $this->entries->saveActivities($entry, $request->activities);
        $this->entries->savePhotos($entry, $request->photos);
        $this->entries->saveGoals($entry, $request->completedGoals);

        return redirect(route('entries.index'));
    }
}
