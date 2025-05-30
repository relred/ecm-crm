<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promoted;
use Illuminate\View\View;
use App\Imports\PromotedImport as ImportPromoted;
use App\Models\PromotedImport as ModelsPromotedImport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class PromotedController extends Controller
{
    public function index(Request $request)
    {
        $query = Promoted::withCount('contactTouches')->where('created_by', auth()->id());
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('locality', 'like', "%{$search}%");
            });
        }
    
        if ($request->filled('municipality')) {
            $query->where('municipality', $request->municipality);
        }

        if ($request->filled('needs_transport')) {
            $value = $request->needs_transport;
            if ($value === 'null') {
                $query->whereNull('needs_transport');
            } else {
                $query->where('needs_transport', (bool) $value);
            }
        }
    
        if ($request->filled('touches')) {
            $query->having('contact_touches_count', '=', (int) $request->touches);
        }
    
        $promoted = $query->latest()->paginate(50)->withQueryString();
    
        $municipalities = Promoted::where('created_by', auth()->id())
            ->select('municipality')
            ->distinct()
            ->pluck('municipality')
            ->filter()
            ->sort();
    
        return view('promoted.index', compact('promoted', 'municipalities'));
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

    public function view(Promoted $promoted)//: View 
    {
        return view('promoted.view', compact('promoted'));
    }

    public function importView()
    {
        $coordinators = User::where('role', 'coordinator')->orderBy('state')->get();
        return view('promoted.import', compact('coordinators'));
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'promoter_id' => 'required|exists:users,id',
        ]);

        $importRecord = ModelsPromotedImport::create([
            'created_by' => auth()->id(),
            'promoter_id' => $request->promoter_id,
        ]);
    
        Excel::import(new ImportPromoted($importRecord), $request->file('file'));
    
        return redirect()->route('promoted.import')->with('success', 'Excel importado correctamente.');
    }
    
}
