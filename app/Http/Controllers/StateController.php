<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('name')->get();
        return view('admin.states.index', compact('states'));
    }

    public function edit(State $state)
    {
        return view('admin.states.edit', compact('state'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'goal' => 'required|integer|min:0'
        ]);

        $state->update([
            'goal' => $request->goal
        ]);

        return redirect()->route('states.index')
            ->with('success', 'Meta actualizada exitosamente.');
    }
} 