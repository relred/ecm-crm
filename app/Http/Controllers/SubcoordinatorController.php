<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

}
