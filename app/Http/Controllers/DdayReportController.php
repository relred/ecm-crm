<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Promoted;
use App\Models\MobilizationActivity;
use App\Models\MobilizationEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DdayReportController extends Controller
{
    public function index()
    {
        // Get all states from users table
        $states = User::whereNotNull('state')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');

        $stateStats = [];

        foreach ($states as $state) {
            // Get active coordinators for this state
            $activeCoordinators = User::where('state', $state)
                ->where('role', 'coordinator')
                ->whereHas('mobilizationActivity')
                ->get();

            if ($activeCoordinators->isEmpty()) {
                $stateStats[$state] = [
                    'has_activity' => false,
                    'promoted_count' => 0,
                    'active_subcoordinators' => 0,
                    'active_operators' => 0,
                    'mobilized_count' => 0,
                    'mobilization_estimate' => 0,
                    'active_coordinators' => [],
                    'system_usage' => null
                ];
                continue;
            }

            // Get promoted count for this state - including all promoted from the hierarchy
            $promotedCount = Promoted::whereHas('creator', function ($query) use ($state) {
                $query->where('state', $state);
            })->count();

            // Get active subcoordinators count
            $activeSubcoordinators = User::where('state', $state)
                ->where('role', 'subcoordinator')
                ->whereHas('mobilizationActivity')
                ->count();

            // Get active operators count
            $activeOperators = User::where('state', $state)
                ->where('role', 'operator')
                ->whereHas('mobilizationActivity')
                ->count();

            // Get mobilized count - including all mobilized from the hierarchy
            $mobilizedCount = Promoted::whereHas('creator', function ($query) use ($state) {
                $query->where('state', $state);
            })
            ->where('mobilized', true)
            ->count();

            // Get mobilization estimates for this state
            $mobilizationEstimate = DB::table('mobilization_estimates')
                ->join('mobilization_activities', 'mobilization_estimates.mobilization_activity_id', '=', 'mobilization_activities.id')
                ->join('users', 'mobilization_activities.user_id', '=', 'users.id')
                ->where('users.state', $state)
                ->whereNotNull('mobilization_estimates.estimated_count')
                ->sum('mobilization_estimates.estimated_count');

            // Determine system usage for the state
            $systemUsage = null;
            $coordinatorUsages = $activeCoordinators->pluck('system_usage')->filter()->unique()->values();
            
            if ($coordinatorUsages->isEmpty()) {
                $systemUsage = null;
            } elseif ($coordinatorUsages->count() === 1) {
                $systemUsage = $coordinatorUsages->first();
            } else {
                $systemUsage = 2; // Mixto
            }

            $stateStats[$state] = [
                'has_activity' => true,
                'promoted_count' => $promotedCount,
                'active_subcoordinators' => $activeSubcoordinators,
                'active_operators' => $activeOperators,
                'mobilized_count' => $mobilizedCount,
                'mobilization_estimate' => $mobilizationEstimate,
                'active_coordinators' => $activeCoordinators->pluck('name')->toArray(),
                'system_usage' => $systemUsage
            ];
        }

        return view('dday.report', compact('stateStats'));
    }

    public function subcoordinators($state)
    {
        $subcoordinators = User::where('state', $state)
            ->where('role', 'subcoordinator')
            ->whereHas('mobilizationActivity')
            ->get();

        return view('dday.subcoordinators', compact('subcoordinators', 'state'));
    }
} 