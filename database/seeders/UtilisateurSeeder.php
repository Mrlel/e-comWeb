<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nom' => 'Mrlela',
            'prenom' => 'Dominique',
            'email' => 'dominiklela456@gmail.com',
            'password' => Hash::make('12345678'), // ⚠️ important
            'telephone' => '0720796688',
            'role' => 'admin'
        ]);
    }
}