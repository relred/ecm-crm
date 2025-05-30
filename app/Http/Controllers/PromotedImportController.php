<?php

namespace App\Http\Controllers;

use App\Models\PromotedImport;
use Illuminate\Http\Request;

class PromotedImportController extends Controller
{
    public function history()
    {
        $imports = PromotedImport::withCount('promoted')
            ->with(['promoted' => fn ($q) => $q->latest()->limit(5)])
            ->latest()
            ->get();

        return view('promoted.import-history', compact('imports'));
    }

    public function rollback(PromotedImport $import)
    {
        if ($import->isCancelled()) {
            return back()->with('error', 'This import has already been cancelled.');
        }

        $import->promoted()->delete();
        $import->update(['cancelled_at' =>  now()]);

        return back()->with('success', 'Importe deshecho con éxito.');
    }

}
