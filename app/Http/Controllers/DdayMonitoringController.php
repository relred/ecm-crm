<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\User;
use App\Models\SpecialSupporter;
use App\Models\MobilizationActivity;
use App\Models\MobilizationEstimate;
use Illuminate\Support\Facades\DB;

class DdayMonitoringController extends Controller
{
    public function index()
    {
        // Get all states with their goals
        $states = State::all();
        $nationalGoal = $states->sum('goal');

        // Get special supporters data
        $specialSupporters = SpecialSupporter::all();
        $specialTotalGoal = $specialSupporters->sum('mobilized_goal');
        $specialCurrentMobilized = $specialSupporters->sum('current_mobilized');

        // Get coordinator estimates
        $coordinatorEstimates = MobilizationEstimate::whereHas('mobilizationActivity', function ($query) {
            $query->where('role', 'coordinator');
        })->get();

        $coordinatorTotalGoal = $coordinatorEstimates->where('mobilization_goal', '!=', null)->sum('mobilization_goal');
        $coordinatorCurrentMobilized = $coordinatorEstimates->where('estimated_count', '!=', null)
            ->groupBy('user_id')
            ->map(function ($userEstimates) {
                return $userEstimates->sum('estimated_count');
            })->sum();

        // Calculate totals
        $totalEstimatedGoal = $specialTotalGoal + $coordinatorTotalGoal;
        $totalCurrentMobilized = $specialCurrentMobilized + $coordinatorCurrentMobilized;

        // Calculate percentages
        $nationalGoalPercentage = $nationalGoal > 0 ? ($totalCurrentMobilized / $nationalGoal) * 100 : 0;
        $estimatedGoalPercentage = $totalEstimatedGoal > 0 ? ($totalCurrentMobilized / $totalEstimatedGoal) * 100 : 0;

        // Get state-by-state breakdown
        $stateBreakdown = $states->map(function ($state) {
            $stateSpecials = SpecialSupporter::where('state', $state->name)->get();
            $stateCoordinators = MobilizationActivity::where('role', 'coordinator')
                ->where('state', $state->name)
                ->get();

            $specialGoal = $stateSpecials->sum('mobilized_goal');
            $specialMobilized = $stateSpecials->sum('current_mobilized');

            $coordinatorGoal = MobilizationEstimate::whereIn('mobilization_activity_id', $stateCoordinators->pluck('id'))
                ->where('mobilization_goal', '!=', null)
                ->sum('mobilization_goal');

            $coordinatorMobilized = MobilizationEstimate::whereIn('mobilization_activity_id', $stateCoordinators->pluck('id'))
                ->where('estimated_count', '!=', null)
                ->sum('estimated_count');

            return [
                'name' => $state->name,
                'goal' => $state->goal,
                'special_goal' => $specialGoal,
                'special_mobilized' => $specialMobilized,
                'coordinator_goal' => $coordinatorGoal,
                'coordinator_mobilized' => $coordinatorMobilized,
                'total_estimated_goal' => $specialGoal + $coordinatorGoal,
                'total_current_mobilized' => $specialMobilized + $coordinatorMobilized,
            ];
        });

        return view('admin.dday-monitoring.index', compact(
            'nationalGoal',
            'totalEstimatedGoal',
            'totalCurrentMobilized',
            'specialTotalGoal',
            'specialCurrentMobilized',
            'coordinatorTotalGoal',
            'coordinatorCurrentMobilized',
            'nationalGoalPercentage',
            'estimatedGoalPercentage',
            'stateBreakdown'
        ));
    }
} 