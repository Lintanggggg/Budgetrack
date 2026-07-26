<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin BudgetRack',
            'email'    => 'admin@budgetrack.com',
            'password' => Hash::make('Admin@12345'),
            'role'     => 'admin',
        ]);
    }
}