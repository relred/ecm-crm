<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Promoted;

class MonitorDashboardController extends Controller
{
    public function index(Request $request)
{
    $state = $request->input('state');

    // Base user query with optional state filter
    $usersQuery = User::query();
    if ($state) {
        $usersQuery->where('state', $state);
    }

    // Count of promoted entries, filtered by creator's state if applicable
    $promotedCount = Promoted::when($state, function ($query, $state) {
        $query->whereHas('creator', function ($q) use ($state) {
            $q->where('state', $state);
        });
    })->count();

    return view('monitor.dashboard', [
        'state' => $state,
        'states' => User::whereNotNull('state')->distinct()->orderBy('state')->pluck('state'),
        'promotedCount' => $promotedCount,
        'promoterCount' => (clone $usersQuery)->role('promoter')->count(),
        'subcoordinatorCount' => (clone $usersQuery)->role('subcoordinator')->count(),
        'coordinatorCount' => (clone $usersQuery)->role('coordinator')->count(),
        'operatorCount' => (clone $usersQuery)->role('operator')->count(),
    ]);
}

}
