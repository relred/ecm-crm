<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ExternalRegisterController extends Controller
{
    public function showForm($parent, $roleHash)
    {

        $roleMap = config('rolelinks.reverse');
        $role = $roleMap[$roleHash] ?? null;

        $displayRoleNames = [
            'operator' => 'Operador',
            'subcoordinator' => 'Operador Enlace',
            'promoter' => 'Promotor',
        ];
        
        $displayRole = $displayRoleNames[$role] ?? ucfirst($role);

        // Basic protection against invalid role
        if (!$role || !in_array($role, ['operator', 'promoter', 'subcoordinator'])) {
            abort(403, 'Invalid or unauthorized role');
        }
    
        $parentUser = User::findOrFail($parent);
    
        // Define allowed invitations per role
        $allowedInvitations = [
            'coordinator' => ['subcoordinator', 'operator'],
            'operator' => ['promoter'],
            'subcoordinator' => ['promoter'],
        ];
    
        // Only allow if the parent can create this role
        if (!isset($allowedInvitations[$parentUser->role]) || !in_array($role, $allowedInvitations[$parentUser->role])) {
            abort(403, 'This user cannot invite someone as ' . $role);
        }
    
        return view('auth.external-register', [
            'parent' => $parentUser,
            'role' => $role,
            'displayRole' => $displayRole,
        ]);
    }    

    public function submitForm(Request $request)
    {
        //return $request;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'role' => 'required',
            'parent_id' => 'required',
            'state' => 'required',
        ]);

        $validated['password'] = Hash::make($request->password);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user); 

        return redirect()->route('dashboard');
    }


}
