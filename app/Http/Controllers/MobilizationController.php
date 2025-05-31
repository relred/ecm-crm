<?php

namespace App\Http\Controllers;

use App\Models\Promoted;
use Illuminate\Http\Request;

class MobilizationController extends Controller
{
    public function index(Promoted $promoted)
    {
        return view('mobilization.index', compact('promoted'));
    }

    public function update(Request $request, Promoted $promoted)
    {
        $promoted->update([
            'mobilized' => true,
            'mobilized_at' => now(),
            'mobilized_by' => auth()->id(),
        ]);

        return redirect()
            ->route('promoted.view', $promoted)
            ->with('success', 'Promovido marcado como movilizado.');
    }
} 