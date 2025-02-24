<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Check if the email already exists
        if (User::where('email', $row['email'])->exists()) {
            return null; // Skip this row
        }

        return new User([
            'name'  => $row['name'],
            'email' => $row['email'],
            'role'  => $row['role'],
            'password' => Hash::make($row['password'] ?? 'defaultpassword'), // Default password (can be changed)
        ]);
    }
}
