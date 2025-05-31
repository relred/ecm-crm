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
    
        // Get touch counts - filtered by state if applicable
        $touchCounts = [
            1 => 0,
            2 => 0,
            3 => 0,
        ];
    
        $touchDataQuery = Promoted::withCount([
            'contactTouches as touch1' => fn ($q) => $q->where('touch_number', 1),
            'contactTouches as touch2' => fn ($q) => $q->where('touch_number', 2),
            'contactTouches as touch3' => fn ($q) => $q->where('touch_number', 3),
        ]);
    
        // Apply state filter to touch data if state is selected
        if ($state) {
            $touchDataQuery->whereHas('creator', function ($q) use ($state) {
                $q->where('state', $state);
            });
        }
    
        $touchData = $touchDataQuery->get();
    
        foreach ($touchData as $promoted) {
            if ($promoted->touch1) $touchCounts[1]++;
            if ($promoted->touch2) $touchCounts[2]++;
            if ($promoted->touch3) $touchCounts[3]++;
        }
    
        // Percentages
        $percentages = [];
        foreach ($touchCounts as $touch => $count) {
            $percentages[$touch] = $promotedCount > 0 ? round(($count / $promotedCount) * 100, 2) : 0;
        }
    
        return view('monitor.dashboard', [
            'state' => $state,
            'states' => User::whereNotNull('state')->distinct()->orderBy('state')->pluck('state'),
            'promotedCount' => $promotedCount,
            'promoterCount' => (clone $usersQuery)->role('promoter')->count(),
            'subcoordinatorCount' => (clone $usersQuery)->role('subcoordinator')->count(),
            'coordinatorCount' => (clone $usersQuery)->role('coordinator')->count(),
            'operatorCount' => (clone $usersQuery)->role('operator')->count(),
            'touchCounts' => $touchCounts,
            'percentages' => $percentages,
        ]);
    }

    public function stateComparison()
    {
        // Get all states
        $states = User::whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
        
        // Initialize stats array
        $stateStats = [];
        
        foreach ($states as $state) {
            // Base user query for this state
            $usersQuery = User::where('state', $state);
            
            // Get promoted count for this state
            $promotedCount = Promoted::whereHas('creator', function ($query) use ($state) {
                $query->where('state', $state);
            })->count();
            
            // Get touch counts for this state
            $touchQuery = Promoted::whereHas('creator', function ($query) use ($state) {
                $query->where('state', $state);
            })->withCount([
                'contactTouches as touch1' => fn ($q) => $q->where('touch_number', 1),
                'contactTouches as touch2' => fn ($q) => $q->where('touch_number', 2),
                'contactTouches as touch3' => fn ($q) => $q->where('touch_number', 3),
            ]);
            
            $touchData = $touchQuery->get();
            
            $touchCounts = [1 => 0, 2 => 0, 3 => 0];
            foreach ($touchData as $promoted) {
                if ($promoted->touch1) $touchCounts[1]++;
                if ($promoted->touch2) $touchCounts[2]++;
                if ($promoted->touch3) $touchCounts[3]++;
            }
            
            // Calculate completion percentage
            $completionPercentage = $promotedCount > 0 
                ? round(($touchCounts[3] / $promotedCount) * 100, 2)
                : 0;
            
            // Store stats for this state
            $stateStats[$state] = [
                'promotedCount' => $promotedCount,
                'promoterCount' => (clone $usersQuery)->role('promoter')->count(),
                'subcoordinatorCount' => (clone $usersQuery)->role('subcoordinator')->count(),
                'coordinatorCount' => (clone $usersQuery)->role('coordinator')->count(),
                'operatorCount' => (clone $usersQuery)->role('operator')->count(),
                'touchCounts' => $touchCounts,
                'completionPercentage' => $completionPercentage,
            ];
        }
        
        // Sort states by completion percentage in descending order
        uasort($stateStats, function($a, $b) {
            return $b['completionPercentage'] <=> $a['completionPercentage'];
        });
        
        return view('monitor.state-comparison', [
            'stateStats' => $stateStats,
        ]);
    }
}
