<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entry\StoreRequest;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use service\ActivityServiceInterface;
use service\EntryServiceInterface;

class EntryController extends Controller
{
    private EntryServiceInterface $entryService;

    private ActivityServiceInterface $activityService;

    public function __construct(EntryServiceInterface $entryService, ActivityServiceInterface $activityService) {
        $this->entryService = $entryService;
        $this->activityService = $activityService;
    }


    public function index(): Response
    {
        $month = date('m');
        return Inertia::render('Entry/Index', [
            'entries' => $this->entryService->collectForIndex($month),
        ]);
    }


    public function create(): Response {
        return Inertia::render("Entry/Save", [
            'entry' => [],
            'collections' => Auth::user()->collections()->with("activities")->get(),
        ]);
    }


    public function store(StoreRequest $request): RedirectResponse {
        $user = $request->user();

        if ($this->entryService->existsForDate($request->date, $user->id)) {
            return back()->withErrors(['date' => 'У вас уже есть запись на эту дату.']);
        }

        $areActivitiesValid = $this->activityService->allExist($request->activities)
            && $this->activityService->ownsEach($request->activities, $user->id);
        if (!$areActivitiesValid) {
            abort(404);
        }

        $entry = $this->entryService->create($request->validated(), $user->id);
        $this->entryService->saveActivities($entry, $request->activities);

        return redirect(route('entries.index'));
    }
}