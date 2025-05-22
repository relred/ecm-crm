<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promoted;

class PromotedController extends Controller
{
    public function index()
    {
        $promoted = Promoted::where('created_by', auth()->id())->latest()->get();

        return view('promoted.index', compact('promoted'));
    }

    public function create()
    {
        return view('promoted.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
    
        $validated['created_by'] = auth()->id();
    
        Promoted::create($validated);
    
        return redirect()->route('promoted.index')->with('status', 'Promovido registrado con éxito');
    }    
}
