<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paiement;
use App\Models\Commande;

class PaiementSeeder extends Seeder
{
    public function run(): void
    {
        $commande = Commande::first();

        Paiement::create([
            'commande_id' => $commande->id,
            'reference_paiement' => 'PAY001',
            'montant' => $commande->montant_total,
            'methode' => 'mobile_money',
            'statut' => 'en_attente',
            'provider' => 'geniuspay',
            'transaction_id' => null
        ]);
    }
}