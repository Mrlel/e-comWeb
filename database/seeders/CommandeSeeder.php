<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commande;
use App\Models\User;

class CommandeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'client')->first();

        Commande::create([
            'user_id' => $user->id,
            'reference_commande' => 'CMD001',
            'montant_total' => 450000,
            'statut' => 'en_attente',
            'adresse_livraison' => 'Abidjan, Cocody'
        ]);
    }
}