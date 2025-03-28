<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entry\IndexRequest;
use App\Http\Requests\Entry\SaveRequest;
use App\Models\Entry;
use App\Models\User;
use App\Services\EntryService;
use App\Services\GoalService;
use App\Services\PhotoService;
use App\Services\Statistics\StatisticsCollector;
use App\Services\Statistics\StatisticsService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    private const DATE_TODAY = 'today';

    private EntryService $entries;

    private PhotoService $photos;

    private GoalService $goals;

    private StatisticsCollector $statisticsCollector;

    private StatisticsService $statisticsService;


    public function __construct(
        EntryService $entryService,
        PhotoService $photoService,
        GoalService $goalService,
        StatisticsCollector $statisticsCollector,
        StatisticsService $statisticsService
    ) {
        $this->entries = $entryService;
        $this->photos = $photoService;
        $this->goals = $goalService;
        $this->statisticsCollector = $statisticsCollector;
        $this->statisticsService = $statisticsService;
    }


    public function open(string $date): Response|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Чтобы при переходе на /entries/today из манифеста не осуществлялась переадресация
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
        }

        return Inertia::render("Entry/Save", [
            'data' => [
                'id' => $entry->id,
                'date' => $entry->date,
                'goals' => $entry->goals->map(fn($goal) => $goal->id),
                'latestGoalCompletions' => $this->goals->collectLatestGoalCompletions($entry->date, $user->id),
                'userGoals' => $user->goals,
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'diary' => $entry->diary,
                'photos' => $entry->photos->map(fn($photo) => $photo->name),
            ]
        ]);
    }


    public function save(SaveRequest $request): Response|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $areRelationsValid = $this->photos->allExist($request->photos) && $this->photos->ownsEach(
                $request->photos,
                $user->id
            );
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entries->save($request->validated());
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


        $goalNodes = $this->statisticsService->getGoalNodes(Auth::user(), 30);

        return Inertia::render('Entry/Index', [
            'goalHeatmap' => $this->statisticsCollector->forGoalHeatmap($goalNodes, 30),
            'entries' => $this->entries->collectForIndex($request->month, $request->year),
            'months' => $this->entries->collectMonthData($request->user()),
        ]);
    }
}
