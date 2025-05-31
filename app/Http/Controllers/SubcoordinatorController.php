<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Promoted;

class SubcoordinatorController extends Controller
{
    function index()
    {
        $users = User::where('role', 'subcoordinator')->where('parent_id', auth()->user()->id)->get();

        $link = route('external.register', [
            'parent' => auth()->id(),
            'roleHash' => config('rolelinks.map')['subcoordinator'],
        ]);

        return view('coordinator.subcoordinators', compact('users'))->with([
            'inviteLink' => $link,
        ]);
    }

    function create()
    {
        return view('coordinator.subcoordinators-create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users',
            'email' => 'nullable|email|unique:users',
            'phone' => 'nullable|string',
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
        $coordinator->state = auth()->user()->state;
        $coordinator->municipality = $request->municipality;
        $coordinator->role = 'subcoordinator';
        $coordinator->parent_id = auth()->id();
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $coordinator->photo = $path;
        }
    
        $coordinator->save();
    
        return redirect()->route('coordinator.subcoordinators.index')->with('success', 'Coordinador creado con contraseña: ' . $plainPassword);
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get all promoters under this subcoordinator
        $promoterCount = User::where('parent_id', $user->id)
            ->where('role', 'promoter')
            ->count();

        // Get all promoted created by promoters under this subcoordinator
        $promotedQuery = Promoted::whereHas('creator', function($query) use ($user) {
            $query->where('parent_id', $user->id)->where('role', 'promoter');
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

        return view('subcoordinator.dashboard', compact(
            'promoterCount',
            'promotedCount',
            'touchCounts',
            'percentages'
        ));
    }

    public function promoterStats(Request $request)
    {
        $user = auth()->user();
        
        $query = User::where('parent_id', $user->id)
            ->where('role', 'promoter')
            ->withCount(['promoted as total_promoted'])
            ->withCount(['promoted as touched_promoted' => function($query) {
                $query->has('contactTouches');
            }])
            ->withCount(['promoted as fully_touched_promoted' => function($query) {
                $query->whereHas('contactTouches', function($q) {
                    $q->where('touch_number', 3);
                });
            }]);

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        $allowedSortFields = ['name', 'total_promoted', 'touched_promoted', 'fully_touched_promoted'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $promoters = $query->paginate(10)->withQueryString();

        // Calculate touch percentage for each promoter
        foreach ($promoters as $promoter) {
            $promoter->touch_percentage = $promoter->total_promoted > 0 
                ? round(($promoter->touched_promoted / $promoter->total_promoted) * 100, 2)
                : 0;
        }

        return view('subcoordinator.promoter-stats', compact('promoters'));
    }
}
