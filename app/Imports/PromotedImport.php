<?php

namespace App\Imports;

use App\Models\Promoted;
use App\Models\PromotedImport as ModelPromotedImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PromotedImport implements ToCollection, WithStartRow, SkipsEmptyRows
{
    protected $import;

    public function __construct(ModelPromotedImport $import)
    {
        $this->import = $import;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            if ($i === 0 || $row->filter()->isEmpty()) continue; // skip header/empty

            $fullName = trim("{$row[0]} {$row[1]} {$row[2]}"); // Paterno + Materno + Nombre

            Promoted::create([
                'created_by' => $this->import->promoter_id,
                'import_id' => $this->import->id,
                'name' => $fullName,
                'address' => $row[6],
                'locality' => $row[7],
                'municipality' => $row[8],
                'phone' => $row[5],
                'notes' => null,
            ]);
        }
    }
}