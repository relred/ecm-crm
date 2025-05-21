<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CoordinatorController extends Controller
{
    function index(): View
    {
        $users = User::where('role', 'coordinator')->get();
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
}
