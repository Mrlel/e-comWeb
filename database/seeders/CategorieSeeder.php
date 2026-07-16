<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Informatique',
            'Téléphones',
            'Accessoires',
            'Mode',
        ];

        foreach ($categories as $nom) {
            Categorie::create([
                'nom' => $nom,
                'description' => "Catégorie $nom"
            ]);
        }
    }
}