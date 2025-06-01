<?php

namespace App\Http\Controllers;

use App\Models\SpecialSupporter;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecialSupporterController extends Controller
{
    public function index()
    {
        $supporters = SpecialSupporter::all();
        $totalGoal = $supporters->sum('mobilized_goal');
        $totalMobilized = $supporters->sum('current_mobilized');
        
        return view('admin.special-supporters.index', compact('supporters', 'totalGoal', 'totalMobilized'));
    }

    public function createLink()
    {
        $token = Str::random(32);
        
        $supporter = SpecialSupporter::create([
            'registration_token' => $token,
            'current_mobilized' => 0,
            'is_registered' => false,
        ]);

        return redirect()->back()->with('link', route('special.register', $token));
    }

    public function showRegistrationForm($token)
    {
        $supporter = SpecialSupporter::where('registration_token', $token)
            ->where('is_registered', false)
            ->firstOrFail();

        $states = State::orderBy('name')->pluck('name');

        return view('special-supporters.register', compact('supporter', 'states'));
    }

    public function register(Request $request, $token)
    {
        $supporter = SpecialSupporter::where('registration_token', $token)
            ->where('is_registered', false)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'mobilized_goal' => 'required|integer|min:1',
        ]);

        $supporter->update([
            ...$validated,
            'is_registered' => true,
        ]);

        return redirect()->route('special.success');
    }

    public function updateMobilized(Request $request, SpecialSupporter $supporter)
    {
        $validated = $request->validate([
            'current_mobilized' => 'required|integer|min:0',
        ]);

        $supporter->update($validated);

        return redirect()->back()->with('success', 'Current mobilized count updated successfully.');
    }
} 