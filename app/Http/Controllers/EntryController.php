<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entry\IndexRequest;
use App\Http\Requests\Entry\SaveRequest;
use App\Models\Entry;
use App\Models\User;
use App\Services\Activity\ActivityServiceInterface;
use App\Services\Entry\EntryServiceInterface;
use App\Services\Goal\GoalServiceInterface;
use App\Services\Photo\PhotoServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    private const DATE_TODAY = 'today';

    private EntryServiceInterface $entries;

    private ActivityServiceInterface $activities;

    private PhotoServiceInterface $photos;

    private GoalServiceInterface $goals;


    public function __construct(EntryServiceInterface $entryService, ActivityServiceInterface $activityService, PhotoServiceInterface $photoService, GoalServiceInterface $goalService)
    {
        $this->entries = $entryService;
        $this->activities = $activityService;
        $this->photos = $photoService;
        $this->goals = $goalService;
    }


    public function open(string $date): Response|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Чтобы на маршруте /entries/today не осуществлялась переадресация
        if ($date == self::DATE_TODAY) {
            $date = date('Y-m-d');
        }

        // Y-m-d
        if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)) {
            return redirect()->intended(route('entries.open', ['date' => date('Y-m-d')]));
        }

        $entry = $user->entries->where('date', Carbon::parse($date))->first();
        if (!$entry) {
            $entry = new Entry();
            $entry->id = 0;
            $entry->date = new Carbon($date);
            $entry->weather = 2;
            $entry->mood = 3;
            $entry->sleeptime = 1;
            $entry->weight = DB::query()->select('weight')->from('entries')->where('user_id', $user->id)->orderByDesc('date')->limit(1)->first()->weight;
            $entry->worktime = 0;
        }

        return Inertia::render("Entry/Save", [
            'data' => [
                'id' => $entry->id,
                'date' => $entry->date,
                'goals' => $entry->goals->map(fn($goal) => $goal->id),
                'lastGoalCompletions' => $this->goals->collectGoalCompletions($entry->date, $user->id),
                'userGoals' => $user->goals,
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'sleeptime' => $entry->sleeptime,
                'weight' => $entry->weight,
                'worktime' => $entry->worktime,
                'diary' => $entry->diary,
                'activities' => $entry->activities->map(fn($activity) => $activity->id),
                'photos' => $entry->photos->map(fn($photo) => $photo->name),
                'collections' => $user->collections()->with("activities")->get(),
            ]
        ]);
    }


    public function save(SaveRequest $request): Response|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $areRelationsValid =
            $this->activities->allExist($request->activities)
            && $this->activities->ownsEach($request->activities, $user->id)
            && $this->photos->allExist($request->photos)
            && $this->photos->ownsEach($request->photos, $user->id);
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entries->save($request->validated());
        $this->entries->saveActivities($entry, $request->activities);
        $this->entries->savePhotos($entry, $request->photos);
        $this->entries->saveGoals($entry, $request->goals);

        return redirect()->intended(route('entries.index'));
    }


    public function index(IndexRequest $request): Response|RedirectResponse
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
}
