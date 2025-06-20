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
                    ->withCount(['childrenPromoted as mobilized_count' => function ($q) {
                        $q->where('mobilized', true);
                    }])
                    ->withCount('childrenPromoted');
            }])
            ->withCount(['children as subcoordinators_count' => function ($query) {
                $query->role('subcoordinator');
            }])
            ->withCount(['children as promoters_count' => function ($query) {
                $query->role('promoter');
            }])
            ->withCount(['childrenPromoted as direct_mobilized_count' => function ($query) {
                $query->where('mobilized', true);
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
                $totalMobilized = $coordinator->direct_mobilized_count;
                foreach ($coordinator->children as $subcoordinator) {
                    $totalPromoted += $subcoordinator->children_promoted_count;
                    $totalMobilized += $subcoordinator->mobilized_count;
                }
                $coordinator->promoted_count = $totalPromoted;
                $coordinator->mobilized_count = $totalMobilized;

                return $coordinator;
            });

        return view('public.coordinators.index', compact('coordinators'));
    }

    public function allMembers(Request $request)
    {
        $selectedTab = $request->get('tab', 'coordinators');
        $selectedState = $request->get('state', '');
        
        // Get all available states
        $states = User::whereNotNull('state')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');

        $data = [];

        // Get coordinators
        if ($selectedTab === 'coordinators') {
            $query = User::role('coordinator')
                ->withCount(['children as subcoordinators_count' => function ($query) {
                    $query->role('subcoordinator');
                }])
                ->withCount(['children as promoters_count' => function ($query) {
                    $query->role('promoter');
                }])
                ->withCount(['childrenPromoted as promoted_count' => function ($query) {
                    $query->where('mobilized', true);
                }])
                ->orderBy('name', 'asc');

            if ($selectedState) {
                $query->where('state', $selectedState);
            }

            $data['coordinators'] = $query->get();
        }

        // Get subcoordinators
        if ($selectedTab === 'subcoordinators') {
            $query = User::role('subcoordinator')
                ->with('parent')
                ->withCount(['children as promoters_count' => function ($query) {
                    $query->role('promoter');
                }])
                ->withCount(['childrenPromoted as promoted_count' => function ($query) {
                    $query->where('mobilized', true);
                }])
                ->orderBy('name', 'asc');

            if ($selectedState) {
                $query->where('state', $selectedState);
            }

            $data['subcoordinators'] = $query->get();
        }

        // Get promoters
        if ($selectedTab === 'promoters') {
            $query = User::role('promoter')
                ->with('parent')
                ->withCount(['promoted as promoted_count'])
                ->withCount(['promoted as mobilized_count' => function ($query) {
                    $query->where('mobilized', true);
                }])
                ->orderBy('name', 'asc');

            if ($selectedState) {
                $query->where('state', $selectedState);
            }

            $data['promoters'] = $query->get();
        }

        // Get promoted
        if ($selectedTab === 'promoted') {
            $query = Promoted::with('creator')
                ->orderBy('mobilized', 'desc')
                ->orderBy('name', 'asc');

            if ($selectedState) {
                $query->whereHas('creator', function ($q) use ($selectedState) {
                    $q->where('state', $selectedState);
                });
            }

            $data['promoted'] = $query->get();
        }

        return view('public.coordinators.all-members', compact('data', 'selectedTab', 'selectedState', 'states'));
    }

    public function subcoordinators(User $coordinator)
    {
        $subcoordinators = $coordinator->children()
            ->role('subcoordinator')
            ->withCount(['children as promoters_count' => function ($query) {
                $query->role('promoter');
            }])
            ->withCount(['childrenPromoted as mobilized_count' => function ($query) {
                $query->where('mobilized', true);
            }])
            ->withCount('childrenPromoted as promoted_count')
            ->get();

        return view('public.coordinators.subcoordinators', compact('coordinator', 'subcoordinators'));
    }

    public function promoters(User $subcoordinator)
    {
        $promoters = $subcoordinator->children()
            ->role('promoter')
            ->withCount(['promoted as mobilized_count' => function ($query) {
                $query->where('mobilized', true);
            }])
            ->withCount('promoted as promoted_count')
            ->get();

        return view('public.coordinators.promoters', compact('subcoordinator', 'promoters'));
    }

    public function promoted(User $promoter)
    {
        $promoted = $promoter->promoted()
            ->orderBy('mobilized', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return view('public.coordinators.promoted', compact('promoter', 'promoted'));
    }
} 