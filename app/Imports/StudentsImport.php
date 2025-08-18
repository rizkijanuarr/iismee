<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function model(array $row)
    {
        // Normalize keys
        $registration = $row['registration_number'] ?? $row['nim'] ?? null;
        $name = $row['name'] ?? null;
        $email = $row['email'] ?? null;
        $class = $row['class'] ?? null;
        $companyName = $row['company_name'] ?? null;
        $division = $row['division'] ?? null;
        $companyAddress = $row['company_address'] ?? null;
        $dateStart = $row['date_start'] ?? null;
        $dateEnd = $row['date_end'] ?? null;
        $internshipType = $row['internship_type'] ?? null;

        // Find or create company by name
        $companyId = null;
        if (!empty($companyName)) {
            $company = Company::firstOrCreate(
                ['company_name' => $companyName],
                [
                    'company_number' => $row['company_number'] ?? null,
                    'company_address' => $companyAddress
                ]
            );
            $companyId = $company->id;
        }

        // Avoid duplicate student by email or registration number
        if ($email && Student::where('email', $email)->exists()) {
            return null;
        }
        if ($registration && Student::where('registration_number', $registration)->exists()) {
            return null;
        }

        // Ensure user exists with default password 1234
        if ($email && !User::where('email', $email)->exists()) {
            User::create([
                'name' => $name ?? ($registration ? ('Mahasiswa ' . $registration) : 'Mahasiswa'),
                'email' => $email,
                'password' => Hash::make('1234'),
                'level' => 'mahasiswa',
                'is_active' => true,
            ]);
        }

        return new Student([
            'registration_number' => $registration,
            'name' => $name,
            'email' => $email,
            'class' => $class,
            'company_id' => $companyId,
            'division' => $division,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'internship_type' => $internshipType,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.registration_number' => ['required'],
            '*.name' => ['required'],
            '*.email' => ['required', 'email'],
            '*.class' => ['required'],
            '*.company_name' => ['nullable', 'string'],
            '*.division' => ['required'],
            '*.date_start' => ['required'],
            '*.date_end' => ['required'],
            '*.internship_type' => ['required'],
        ];
    }
}
