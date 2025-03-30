<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entry\IndexRequest;
use App\Http\Requests\Entry\SaveRequest;
use App\Http\Resources\EntryCardResource;
use App\Models\Entry;
use App\Models\User;
use App\Services\EntryService;
use App\Services\GoalService;
use App\Services\PhotoService;
use App\Services\Statistics\StatisticsCollector;
use App\Services\Statistics\NodeCollector;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    private const DATE_TODAY = 'today';

    private EntryService $entryService;

    private PhotoService $photoService;

    private GoalService $goalService;

    private StatisticsCollector $statisticsCollector;

    private NodeCollector $nodeCollector;


    public function __construct(
        EntryService $entryService,
        PhotoService $photoService,
        GoalService $goalService,
        StatisticsCollector $statisticsCollector,
        NodeCollector $nodeCollector
    ) {
        $this->entryService = $entryService;
        $this->photoService = $photoService;
        $this->goalService = $goalService;
        $this->statisticsCollector = $statisticsCollector;
        $this->nodeCollector = $nodeCollector;
    }


    public function open(Request $request, string $date): Response|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // This will avoid unnecessary redirects when navigating the route /entries/today
        if ($date == self::DATE_TODAY) {
            $date = date('Y-m-d');
        }

        // Y-m-d
        if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)) {
            return redirect()->intended(route('entries.open', ['date' => date('Y-m-d')]));
        }

        $entry = $user->entries->where('date', Carbon::parse($date))->first()
            ?? $this->entryService->createDefaultInstance($date);

        $latestGoalCompletions = $this->goalService->collectLatestGoalCompletions($entry->date, $user->id);
        $resource = new EntryCardResource($entry, $user->goals, $latestGoalCompletions);

        return Inertia::render("Entry/Save", $resource->toArray($request));
    }


    public function save(SaveRequest $request): Response|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $areRelationsValid = $this->photoService->allExist($request->photos) && $this->photoService->ownsEach(
                $request->photos,
                $user->id
            );
        if (!$areRelationsValid) {
            abort(404);
        }

        $entry = $this->entryService->save($request->validated());
        $this->entryService->syncPhotos($entry, $request->photos);
        $this->entryService->syncGoals($entry, $request->goals);

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


        $goalNodes = $this->nodeCollector->collectGoalNodes(Auth::user(), 30);

        return Inertia::render('Entry/Index', [
            'goalHeatmap' => $this->statisticsCollector->forGoalHeatmap($goalNodes, 30),
            'entries' => $this->entryService->collectForIndex($request->month, $request->year),
            'months' => $this->entryService->collectMonthData($request->user()),
        ]);
    }
}
