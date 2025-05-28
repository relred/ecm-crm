<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promoted;
use App\Models\Touch;

class FollowUpController extends Controller
{
    
    public function index(Promoted $promoted)
    {

        $touches = $promoted->contactTouches()->with('user')->orderBy('touch_number')->get();

        // Get touch numbers already registered
        $registeredNumbers = $touches->pluck('touch_number')->all();
    
        // Determine the next valid touch number (1 to 3)
        $nextTouch = null;
        for ($i = 1; $i <= 3; $i++) {
            if (!in_array($i, $registeredNumbers)) {
                $nextTouch = $i;
                break;
            }
        }
    
        return view('followup.index', compact('promoted', 'touches', 'nextTouch'));
    }
    public function storeTouch(Request $request, Promoted $promoted)
    {
        $validated = $request->validate([
            'touch_number' => 'required|integer|between:1,3',
            'method' => 'nullable|in:call,whatsapp,sms,other',
            'notes' => 'nullable|string',
        ]);
    
        // Determine expected next touch
        $existing = $promoted->contactTouches()->pluck('touch_number')->all();
        $expectedTouch = null;
        for ($i = 1; $i <= 3; $i++) {
            if (!in_array($i, $existing)) {
                $expectedTouch = $i;
                break;
            }
        }
    
        if ((int) $validated['touch_number'] !== $expectedTouch) {
            return back()->with('error', 'Debes registrar el Toque ' . $expectedTouch . ' antes de continuar.');
        }
    
        $validated['promoted_id'] = $promoted->id;
        $validated['user_id'] = auth()->id();
        $validated['touched_at'] = now();
    
        Touch::create($validated);
    
        return redirect()->route('followup.index', $promoted)->with('success', 'Toque registrado.');
    }
    
}
