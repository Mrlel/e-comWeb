<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use App\Models\Categorie;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Categorie::all();

        $produits = [
            [
                'nom' => 'Ordinateur Portable',
                'description' => 'PC performant',
                'prix' => 450,
                'stock' => 10,
                'categorie' => 'Informatique'
            ],
            [
                'nom' => 'Clavier Gaming',
                'description' => 'Clavier RGB mécanique',
                'prix' => 250,
                'stock' => 20,
                'categorie' => 'Informatique'
            ],
            [
                'nom' => 'iPhone 13',
                'description' => 'Smartphone Apple',
                'prix' => 800,
                'stock' => 5,
                'categorie' => 'Téléphones'
            ],
            [
                'nom' => 'Samsung Galaxy S21',
                'description' => 'Smartphone Android',
                'prix' => 600,
                'stock' => 8,
                'categorie' => 'Téléphones'
            ],
            [
                'nom' => 'Casque Bluetooth',
                'description' => 'Casque sans fil',
                'prix' => 300,
                'stock' => 15,
                'categorie' => 'Accessoires'
            ],
            [
                'nom' => 'T-shirt Homme',
                'description' => 'T-shirt coton',
                'prix' => 100,
                'stock' => 50,
                'categorie' => 'Mode'
            ],
        ];

        foreach ($produits as $data) {
            $categorie = $categories->where('nom', $data['categorie'])->first();

            Produit::create([
                'nom' => $data['nom'],
                'description' => $data['description'],
                'prix' => $data['prix'],
                'stock' => $data['stock'],
                'categorie_id' => $categorie->id
            ]);
        }
    }
}