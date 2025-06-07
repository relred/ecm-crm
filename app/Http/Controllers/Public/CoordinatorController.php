<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Promoted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = User::role('coordinator')->orderBy('state', 'asc')
            ->with(['children' => function ($query) {
                $query->role('subcoordinator')
                    ->withCount(['children as promoters_count' => function ($q) {
                        $q->role('promoter');
                    }])
                    ->withCount('childrenPromoted');
            }])
            ->withCount(['children as subcoordinators_count' => function ($query) {
                $query->role('subcoordinator');
            }])
            ->withCount(['children as promoters_count' => function ($query) {
                $query->role('promoter');
            }])
            ->withCount('childrenPromoted as direct_promoted_count')
            ->get()
            ->map(function ($coordinator) {
                // Calculate total promoters (direct + from subcoordinators)
                $totalPromoters = $coordinator->promoters_count;
                foreach ($coordinator->children as $subcoordinator) {
                    $totalPromoters += $subcoordinator->promoters_count;
                }
                $coordinator->promoters_count = $totalPromoters;

                // Calculate total promoted (direct + from subcoordinators)
                $totalPromoted = $coordinator->direct_promoted_count;
                foreach ($coordinator->children as $subcoordinator) {
                    $totalPromoted += $subcoordinator->children_promoted_count;
                }
                $coordinator->promoted_count = $totalPromoted;

                return $coordinator;
            });

        return view('public.coordinators.index', compact('coordinators'));
    }

    public function subcoordinators(User $coordinator)
    {
        $subcoordinators = $coordinator->children()
            ->role('subcoordinator')
            ->withCount(['children as promoters_count' => function ($query) {
                $query->role('promoter');
            }])
            ->withCount('childrenPromoted as promoted_count')
            ->get();

        return view('public.coordinators.subcoordinators', compact('coordinator', 'subcoordinators'));
    }

    public function promoters(User $subcoordinator)
    {
        $promoters = $subcoordinator->children()
            ->role('promoter')
            ->withCount('promoted as promoted_count')
            ->get();

        return view('public.coordinators.promoters', compact('subcoordinator', 'promoters'));
    }

    public function promoted(User $promoter)
    {
        $promoted = $promoter->promoted()
            ->get();

        return view('public.coordinators.promoted', compact('promoter', 'promoted'));
    }
} 