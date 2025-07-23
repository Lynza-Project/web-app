<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersImportTemplate implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return new Collection([
            ['Louis', 'Reynard', 'louisreynard@gmail.fr', 'user'],
        ]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Prénom',
            'Nom',
            'Email',
            'Rôle (user ou admin)',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
