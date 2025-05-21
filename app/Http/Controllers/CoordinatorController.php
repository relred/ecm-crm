<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    public function create()
    {
        return view('users.create-coordinator');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'state' => 'required|string',
            'municipality' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $coordinator = new User();
        $coordinator->name = $request->name;
        $coordinator->username = $request->username;
        $coordinator->password = Hash::make($request->password);
        $coordinator->email = $request->email;
        $coordinator->phone = $request->phone;
        $coordinator->state = $request->state;
        $coordinator->municipality = $request->municipality;
        $coordinator->role = 'coordinator';
        $coordinator->parent_id = auth()->id(); // created by admin

        // Handle photo if needed

        $coordinator->save();

        return redirect()->route('dashboard')->with('success', 'Coordinador creado');
    }
}
