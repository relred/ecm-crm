<?php

namespace App\Http\Controllers;

use App\Models\MobilizationActivity;
use App\Models\MobilizationEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobilizationEstimateController extends Controller
{
    public function showEstimateForm()
    {
        $user = Auth::user();
        $activity = MobilizationActivity::where('user_id', $user->id)->firstOrFail();
        
        // Get the initial goal estimate if it exists
        $initialEstimate = $activity->estimates()
            ->whereNotNull('mobilization_goal')
            ->first();
        
        // Get all update estimates
        $estimates = $activity->estimates()
            ->whereNotNull('estimated_count')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('mobilization.estimate', compact('activity', 'estimates', 'initialEstimate'));
    }

    public function showUpdateForm()
    {
        $user = Auth::user();
        $activity = MobilizationActivity::where('user_id', $user->id)->firstOrFail();
        
        // Get the initial goal estimate
        $initialEstimate = $activity->estimates()
            ->whereNotNull('mobilization_goal')
            ->firstOrFail();
        
        return view('mobilization.update-estimate', compact('activity', 'initialEstimate'));
    }

    public function submitGoal(Request $request)
    {
        $request->validate([
            'mobilization_goal' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $activity = MobilizationActivity::where('user_id', $user->id)->firstOrFail();

        // Check if goal already exists
        if ($activity->estimates()->whereNotNull('mobilization_goal')->exists()) {
            return redirect()
                ->route('mobilization.estimate')
                ->with('error', 'Ya has establecido tu objetivo de movilización.');
        }

        $estimate = new MobilizationEstimate([
            'user_id' => $user->id,
            'mobilization_activity_id' => $activity->id,
            'mobilization_goal' => $request->mobilization_goal,
            'notes' => $request->notes
        ]);

        $estimate->save();

        return redirect()
            ->route('mobilization.estimate')
            ->with('success', 'Objetivo de movilización establecido correctamente.');
    }

    public function submitEstimate(Request $request)
    {
        $request->validate([
            'estimated_count' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $activity = MobilizationActivity::where('user_id', $user->id)->firstOrFail();

        // Check if goal exists
        if (!$activity->estimates()->whereNotNull('mobilization_goal')->exists()) {
            return redirect()
                ->route('mobilization.estimate')
                ->with('error', 'Primero debes establecer tu objetivo de movilización.');
        }

        $estimate = new MobilizationEstimate([
            'user_id' => $user->id,
            'mobilization_activity_id' => $activity->id,
            'estimated_count' => $request->estimated_count,
            'notes' => $request->notes
        ]);

        $estimate->save();

        return view('mobilization.update-success');
    }
} 