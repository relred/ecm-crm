<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PromoterController extends Controller
{
    function index()
    {
        $user = auth()->user();

        $users = User::where('role', 'promoter')->where('parent_id', $user->id)->get();

        $link = route('external.register', [
            'parent' => auth()->id(),
            'roleHash' => config('rolelinks.map')['promoter'],
        ]);

        return view('promoters.index', compact('users'))->with([
            'inviteLink' => $link,
        ]);
    }

    function create()
    {
        return view('promoters.create');
    }

    function store(Request $request)
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
        $coordinator->public_password = $plainPassword;
        $coordinator->email = $request->email;
        $coordinator->phone = $request->phone;
        $coordinator->state = auth()->user()->state;
        $coordinator->municipality = $request->municipality;
        $coordinator->role = 'promoter';
        $coordinator->parent_id = auth()->id();
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $coordinator->photo = $path;
        }
    
        $coordinator->save();
    
        return redirect()->route('promoters')->with('success', 'Coordinador creado con contraseña: ' . $plainPassword);
    }

    public function view(User $promoter)
    {
        // Ensure the promoter belongs to the current subcoordinator
        if ($promoter->parent_id !== auth()->id()) {
            abort(403);
        }

        // Get statistics
        $promotedQuery = $promoter->promoted();
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

        // Get recent promoted
        $recentPromoted = $promoter->promoted()
            ->withCount(['contactTouches'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('promoters.view', compact(
            'promoter',
            'promotedCount',
            'touchCounts',
            'percentages',
            'recentPromoted'
        ));
    }
}
