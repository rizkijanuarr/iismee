<?php

namespace App\Imports;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class LecturersImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    public function model(array $row)
    {
        $nip = $row['lecturer_id_number'] ?? $row['nip'] ?? null;
        $name = $row['name'] ?? null;
        $email = $row['email'] ?? null;
        $phone = $row['phone_number'] ?? $row['phone'] ?? null;

        // Avoid duplicate by email or NIP
        if ($email && Lecturer::where('email', $email)->exists()) {
            return null;
        }
        if ($nip && Lecturer::where('lecturer_id_number', $nip)->exists()) {
            return null;
        }

        // Ensure user exists with default password 1234
        if ($email && !User::where('email', $email)->exists()) {
            User::create([
                'name' => $name ?? 'Dosen',
                'email' => $email,
                'password' => Hash::make('1234'),
                'level' => 'dosen',
                'is_active' => true,
            ]);
        }

        return new Lecturer([
            'lecturer_id_number' => $nip,
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.lecturer_id_number' => ['required'],
            '*.name' => ['required'],
            '*.email' => ['required', 'email'],
            '*.phone_number' => ['required'],
        ];
    }
}
