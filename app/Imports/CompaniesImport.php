<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class CompaniesImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    /**
     * Map each row to a Company model.
     * Expected headings: company_name, company_number, company_address
     * You can adjust to match your Excel header names.
     */
    public function model(array $row)
    {
        // Skip if company_name missing
        if (empty($row['company_name'])) {
            return null;
        }

        // Update or create by company_name to avoid duplicates
        $attributes = [
            'company_name' => trim((string)($row['company_name'] ?? '')),
        ];

        $values = [
            'company_number' => isset($row['company_number']) ? trim((string)$row['company_number']) : null,
            'company_address' => isset($row['company_address']) ? trim((string)$row['company_address']) : null,
        ];

        // Use firstOrCreate/update
        $company = Company::firstOrNew($attributes);
        $company->fill($values);
        $company->save();

        return $company;
    }

    public function rules(): array
    {
        return [
            '*.company_name' => ['required','string'],
            '*.company_address' => ['nullable','string'],
            '*.company_number' => ['nullable','string'],
        ];
    }
}
