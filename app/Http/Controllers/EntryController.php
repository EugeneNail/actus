<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use service\EntryServiceInterface;

class EntryController extends Controller
{
    private EntryServiceInterface $service;

    public function __construct(EntryServiceInterface $service) {
        $this->service = $service;
    }


    public function index(): Response
    {
        $month = date('m');
        return Inertia::render('Entry/Index', [
            'entries' => $this->service->collectForIndex($month),
        ]);
    }
}
