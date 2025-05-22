<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    function index()
    {
        $user = Auth::user();

        $users = User::where('role', 'operator')
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                // If not admin, only show operators whose parent is the current user
                $query->where('parent_id', $user->id);
            }, function ($query) {
                // If admin, show operators whose parent is an admin
                $query->whereHas('parent', function ($q) {
                    $q->where('role', 'admin');
                });
            })
            ->get();


        return view('admin.operators', compact('users'));
    }

    function create()
    {
        return view('admin.operators-create');
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
        $coordinator->public_password = $plainPassword; // You must have this column in your `users` table
        $coordinator->email = $request->email;
        $coordinator->phone = $request->phone;
        $coordinator->state = auth()->user()->role == 'admin' ? $request->state : auth()->user()->state;
        $coordinator->municipality = $request->municipality;
        $coordinator->role = 'operator';
        $coordinator->parent_id = auth()->id();
    
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $coordinator->photo = $path;
        }
    
        $coordinator->save();
    
        return redirect()->route('operators')->with('success', 'Coordinador creado con contraseña: ' . $plainPassword);
    }
}
