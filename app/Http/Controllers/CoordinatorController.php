<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Promoted;

class CoordinatorController extends Controller
{
    function index(): View
    {
        $users = User::role('coordinator')->get();
        return view('admin.coordinators', compact('users'));
    }

    public function create()
    {
        return view('admin.coordinators-create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users',
            'email' => 'nullable|email|unique:users',
            'phone' => 'nullable|string',
            'state' => 'nullable|string',
            'municipality' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Generate a simple Spanish password
        $words = ['madera', 'arbol', 'soles', 'luna', 'nube', 'tierra', 'fuego', 'agua', 'flor', 'cielo'];
        $word = $words[array_rand($words)];
        $number = rand(100, 999);
        $plainPassword = $word . $number;

        $coordinator = new User();
        $coordinator->name = $request->name;
        $coordinator->username = $request->username;
        $coordinator->password = Hash::make($plainPassword);
        $coordinator->public_password = $plainPassword; // You must have this column in your `users` table
        $coordinator->email = $request->email;
        $coordinator->phone = $request->phone;
        $coordinator->state = $request->state;
        $coordinator->municipality = $request->municipality;
        $coordinator->role = 'coordinator';
        $coordinator->parent_id = auth()->id();
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $coordinator->photo = $path;
        }
    
        $coordinator->save();
    
        return redirect()->route('dashboard')->with('success', 'Coordinador creado con contraseña: ' . $plainPassword);
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get all subcoordinators under this coordinator
        $subcoordinatorCount = User::where('parent_id', $user->id)
            ->where('role', 'subcoordinator')
            ->count();

        // Get all promoters under this coordinator's subcoordinators
        $promoterCount = User::whereHas('parent', function($query) use ($user) {
            $query->where('parent_id', $user->id)->where('role', 'subcoordinator');
        })->where('role', 'promoter')->count();

        // Get all promoted created by promoters under this coordinator's hierarchy
        $promotedQuery = Promoted::whereHas('creator', function($query) use ($user) {
            $query->whereHas('parent', function($q) use ($user) {
                $q->where('parent_id', $user->id)->where('role', 'subcoordinator');
            })->where('role', 'promoter');
        });
        
        $promotedCount = $promotedQuery->count();

        // Get touch statistics
        $touchCounts = [1 => 0, 2 => 0, 3 => 0];
        $touchData = $promotedQuery->withCount([
            'contactTouches as touch1' => fn ($q) => $q->where('touch_number', 1),
            'contactTouches as touch2' => fn ($q) => $q->where('touch_number', 2),
            'contactTouches as touch3' => fn ($q) => $q->where('touch_number', 3),
        ])->get();

        foreach ($touchData as $promoted) {
            if ($promoted->touch1) $touchCounts[1]++;
            if ($promoted->touch2) $touchCounts[2]++;
            if ($promoted->touch3) $touchCounts[3]++;
        }

        // Calculate percentages
        $percentages = [];
        foreach ($touchCounts as $touch => $count) {
            $percentages[$touch] = $promotedCount > 0 ? round(($count / $promotedCount) * 100, 2) : 0;
        }

        // Get subcoordinator performance summary
        $subcoordinators = User::where('parent_id', $user->id)
            ->where('role', 'subcoordinator')
            ->withCount(['children as promoter_count' => function($query) {
                $query->where('role', 'promoter');
            }])
            ->withCount(['childrenPromoted as promoted_count' => function($query) {
                $query->whereHas('creator', function($q) {
                    $q->where('role', 'promoter');
                });
            }])
            ->withCount(['childrenPromoted as touched_count' => function($query) {
                $query->whereHas('creator', function($q) {
                    $q->where('role', 'promoter');
                })->has('contactTouches');
            }])
            ->withCount(['childrenPromoted as fully_touched_count' => function($query) {
                $query->whereHas('creator', function($q) {
                    $q->where('role', 'promoter');
                })->whereHas('contactTouches', function($q) {
                    $q->where('touch_number', 3);
                });
            }])
            ->take(5)
            ->get();

        return view('coordinator.dashboard', compact(
            'subcoordinatorCount',
            'promoterCount',
            'promotedCount',
            'touchCounts',
            'percentages',
            'subcoordinators'
        ));
    }

    public function subcoordinatorStats(Request $request)
    {
        $user = auth()->user();
        
        $query = User::where('parent_id', $user->id)
            ->where('role', 'subcoordinator')
            ->withCount(['children as promoter_count' => function($query) {
                $query->where('role', 'promoter');
            }])
            ->withCount(['childrenPromoted as total_promoted' => function($query) {
                $query->whereHas('creator', function($q) {
                    $q->where('role', 'promoter');
                });
            }])
            ->withCount(['childrenPromoted as touched_promoted' => function($query) {
                $query->whereHas('creator', function($q) {
                    $q->where('role', 'promoter');
                })->has('contactTouches');
            }])
            ->withCount(['childrenPromoted as fully_touched_promoted' => function($query) {
                $query->whereHas('creator', function($q) {
                    $q->where('role', 'promoter');
                })->whereHas('contactTouches', function($q) {
                    $q->where('touch_number', 3);
                });
            }]);

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('municipality', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        $allowedSortFields = ['name', 'promoter_count', 'total_promoted', 'touched_promoted', 'fully_touched_promoted'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $subcoordinators = $query->paginate(10)->withQueryString();

        // Calculate touch percentage for each subcoordinator
        foreach ($subcoordinators as $subcoordinator) {
            $subcoordinator->touch_percentage = $subcoordinator->total_promoted > 0 
                ? round(($subcoordinator->touched_promoted / $subcoordinator->total_promoted) * 100, 2)
                : 0;
        }

        return view('coordinator.subcoordinator-stats', compact('subcoordinators'));
    }
}
