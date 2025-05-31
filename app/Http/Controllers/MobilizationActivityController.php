<?php

namespace App\Http\Controllers;

use App\Models\MobilizationActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MobilizationActivityController extends Controller
{
    public function showConfirmation()
    {
        // Check if user has already confirmed activity
        $existingActivity = MobilizationActivity::where('user_id', Auth::id())->exists();
        
        if ($existingActivity) {
            return view('mobilization.already-confirmed');
        }

        return view('mobilization.confirm');
    }

    public function confirm()
    {
        // Check if user has already confirmed activity
        $existingActivity = MobilizationActivity::where('user_id', Auth::id())->exists();
        
        if ($existingActivity) {
            return redirect()->back()->with('error', 'Ya has confirmado tu actividad.');
        }

        $user = Auth::user();

        // Create activity record
        MobilizationActivity::create([
            'user_id' => $user->id,
            'role' => $user->role,
            'state' => $user->state,
            'municipality' => $user->municipality,
        ]);

        return redirect()->route('mobilization.confirmed');
    }

    public function showConfirmed()
    {
        return view('mobilization.confirmed');
    }

    public function analytics()
    {
        // Get counts by role
        $roleCounts = MobilizationActivity::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        // Get total users by role for percentage calculation
        $totalByRole = \App\Models\User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        // Calculate percentages
        $percentages = [];
        foreach ($roleCounts as $role => $count) {
            $total = $totalByRole[$role] ?? 0;
            $percentages[$role] = $total > 0 ? round(($count / $total) * 100, 1) : 0;
        }

        // Get counts by state
        $stateCounts = MobilizationActivity::whereNotNull('state')
            ->selectRaw('state, count(*) as count')
            ->groupBy('state')
            ->get();

        return view('mobilization.analytics', compact('roleCounts', 'percentages', 'stateCounts'));
    }

    public function managePromoters()
    {
        $user = Auth::user();
        
        // Get all promoters under this user
        $promoters = User::where('parent_id', $user->id)
            ->where('role', 'promoter')
            ->get()
            ->map(function ($promoter) {
                // Check if promoter is active
                $promoter->is_active = MobilizationActivity::where('user_id', $promoter->id)->exists();
                return $promoter;
            });

        return view('mobilization.manage-promoters', compact('promoters'));
    }

    public function manageSubcoordinators()
    {
        $user = Auth::user();
        
        // Get all subcoordinators under this coordinator
        $subcoordinators = User::where('parent_id', $user->id)
            ->where('role', 'subcoordinator')
            ->get()
            ->map(function ($subcoordinator) {
                // Check if subcoordinator is active
                $subcoordinator->is_active = MobilizationActivity::where('user_id', $subcoordinator->id)->exists();
                
                // Get promoters counts
                $promoters = User::where('parent_id', $subcoordinator->id)
                    ->where('role', 'promoter')
                    ->get();
                
                $subcoordinator->total_promoters_count = $promoters->count();
                $subcoordinator->active_promoters_count = MobilizationActivity::whereIn('user_id', $promoters->pluck('id'))
                    ->count();
                
                return $subcoordinator;
            });

        return view('mobilization.manage-subcoordinators', compact('subcoordinators'));
    }
} 