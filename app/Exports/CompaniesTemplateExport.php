<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'company_name',
            'company_number',
            'company_address',
        ];
    }

    public function array(): array
    {
        return [
            ['PT Contoh Satu', '021-1234567', 'Jl. Mawar No. 1, Jakarta'],
            ['CV Contoh Dua', '0812-3456-7890', 'Jl. Melati No. 2, Bandung'],
        ];
    }
}
