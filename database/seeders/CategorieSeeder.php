<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Mode' => "Vêtements du quotidien : hauts, bas, ensembles et pièces intemporelles.",
            'Robes' => "Robes fluides, portefeuille ou de soirée pour toutes les occasions.",
            'Mayo' => "Maillots de bain et bikinis pour la plage et la piscine.",
            'Chapeau' => "Chapeaux, bobs et casquettes pour parfaire chaque tenue.",
            'Africaine' => "Imprimés wax et pièces inspirées des tissus africains.",
            'Tendance' => "Les pièces du moment, sélectionnées pour leur style affirmé.",
            'Lunettes' => "Lunettes de soleil pour twister toutes les silhouettes.",
        ];

        foreach ($categories as $nom => $description) {
            // updateOrCreate : ne duplique pas les catégories déjà créées manuellement
            // et ne touche pas à l'image déjà téléversée depuis le back-office.
            Categorie::updateOrCreate(
                ['nom' => $nom],
                ['description' => $description]
            );
        }
    }
}
