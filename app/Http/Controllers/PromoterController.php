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
}
