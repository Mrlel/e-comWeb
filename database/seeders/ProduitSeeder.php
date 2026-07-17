<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use App\Models\Categorie;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Categorie::pluck('id', 'nom');

        // Images déjà présentes dans storage/app/public/produits, réparties en tournante
        // pour varier le rendu visuel des cartes produit sans dépendre du placeholder distant.
        $images = [
            'produits/BIwG4PSPaePGcThwd2oBzLh2HDGt09aVbGfVoxAi.jpg',
            'produits/Elu8OA4kjHj5v9k5IeSBMSAVKmHYvUEKkLKbr3Yb.jpg',
            'produits/iuWNysdJHPFNTLssfyypbjjDLrvcYzm1H8m36np7.jpg',
        ];

        $produits = [
            // Mode
            ['nom' => 'Blouse en soie ivoire', 'description' => "Blouse fluide en soie, col fonctionnel et manches ajustées. Un basique chic pour le bureau comme pour le soir.", 'prix' => 15000, 'stock' => 18, 'categorie' => 'Mode'],
            ['nom' => 'Ensemble tailleur chic', 'description' => "Blazer cintré et pantalon assorti, coupe structurée pour une silhouette impeccable.", 'prix' => 28000, 'stock' => 10, 'categorie' => 'Mode'],
            ['nom' => 'Jean taille haute', 'description' => "Denim stretch taille haute, coupe droite flatteuse, confortable toute la journée.", 'prix' => 12000, 'stock' => 25, 'categorie' => 'Mode'],
            ['nom' => 'Top côtelé manches longues', 'description' => "Haut côtelé extensible, coupe ajustée, idéal en pièce du dessous ou seul.", 'prix' => 9000, 'stock' => 30, 'categorie' => 'Mode'],

            // Robes
            ['nom' => 'Robe fluide à volants', 'description' => "Robe légère à volants, tissu aérien pour un tombé gracieux en toute saison.", 'prix' => 29900, 'stock' => 14, 'categorie' => 'Robes'],
            ['nom' => 'Robe portefeuille imprimée', 'description' => "Robe portefeuille à nouer, imprimé exclusif, coupe flatteuse pour toutes les morphologies.", 'prix' => 22000, 'stock' => 16, 'categorie' => 'Robes'],
            ['nom' => 'Robe longue de soirée', 'description' => "Robe longue fendue, tissu satiné, parfaite pour les grandes occasions.", 'prix' => 35000, 'stock' => 8, 'categorie' => 'Robes'],
            ['nom' => 'Robe bustier satinée', 'description' => "Robe bustier ajustée en satin, coupe midi, pour un look glamour et raffiné.", 'prix' => 26000, 'stock' => 12, 'categorie' => 'Robes'],

            // Mayo
            ['nom' => 'Maillot une pièce échancré', 'description' => "Maillot de bain une pièce à découpes, maintien optimal et finition douce.", 'prix' => 14000, 'stock' => 20, 'categorie' => 'Mayo'],
            ['nom' => 'Bikini triangle imprimé tropical', 'description' => "Bikini triangle réglable, imprimé tropical vibrant, séchage rapide.", 'prix' => 11000, 'stock' => 22, 'categorie' => 'Mayo'],
            ['nom' => 'Maillot de bain drapé noir', 'description' => "Maillot drapé sculptant, coloris noir intemporel, doublure intégrale.", 'prix' => 13500, 'stock' => 18, 'categorie' => 'Mayo'],

            // Chapeau
            ['nom' => 'Chapeau de paille à large bord', 'description' => "Chapeau en paille tressée, large bord pour une protection solaire élégante.", 'prix' => 8500, 'stock' => 15, 'categorie' => 'Chapeau'],
            ['nom' => 'Bob en toile beige', 'description' => "Bob en toile légère, coloris beige neutre, ajustable et pliable.", 'prix' => 5000, 'stock' => 24, 'categorie' => 'Chapeau'],
            ['nom' => 'Casquette brodée', 'description' => "Casquette en coton avec broderie signature, visière courbée.", 'prix' => 4500, 'stock' => 28, 'categorie' => 'Chapeau'],

            // Africaine
            ['nom' => 'Robe wax imprimée', 'description' => "Robe confectionnée en tissu wax authentique, coupe cintrée et couleurs éclatantes.", 'prix' => 24000, 'stock' => 12, 'categorie' => 'Africaine'],
            ['nom' => 'Ensemble pagne deux pièces', 'description' => "Haut et jupe assortis en pagne, finitions soignées, coupe moderne.", 'prix' => 27000, 'stock' => 10, 'categorie' => 'Africaine'],
            ['nom' => 'Turban wax assorti', 'description' => "Turban en wax prêt à nouer, parfait pour compléter une tenue imprimée.", 'prix' => 6000, 'stock' => 20, 'categorie' => 'Africaine'],

            // Tendance
            ['nom' => 'Combinaison pantalon élégante', 'description' => "Combinaison fluide à ceinture marquée, silhouette longiligne et moderne.", 'prix' => 26000, 'stock' => 11, 'categorie' => 'Tendance'],
            ['nom' => 'Veste oversize en jean', 'description' => "Veste en denim coupe oversize, pièce polyvalente pour toutes les saisons.", 'prix' => 18000, 'stock' => 16, 'categorie' => 'Tendance'],
            ['nom' => 'Jupe plissée satinée', 'description' => "Jupe mi-longue plissée en satin, mouvement fluide à chaque pas.", 'prix' => 14500, 'stock' => 19, 'categorie' => 'Tendance'],

            // Lunettes
            ['nom' => "Lunettes de soleil œil de chat", 'description' => "Monture œil de chat tendance, verres teintés avec protection UV400.", 'prix' => 8900, 'stock' => 26, 'categorie' => 'Lunettes'],
            ['nom' => 'Lunettes aviateur dorées', 'description' => "Monture aviateur dorée, verres dégradés, un classique indémodable.", 'prix' => 9900, 'stock' => 22, 'categorie' => 'Lunettes'],
            ['nom' => 'Lunettes rondes rétro', 'description' => "Monture ronde fine au style rétro, légère et confortable au quotidien.", 'prix' => 7500, 'stock' => 24, 'categorie' => 'Lunettes'],
        ];

        foreach ($produits as $index => $data) {
            $categorieId = $categories[$data['categorie']] ?? null;

            if (!$categorieId) {
                continue; // catégorie absente en base, on ignore ce produit plutôt que d'échouer
            }

            Produit::firstOrCreate(
                ['nom' => $data['nom']],
                [
                    'description' => $data['description'],
                    'prix' => $data['prix'],
                    'stock' => $data['stock'],
                    'categorie_id' => $categorieId,
                    'image' => $images[$index % count($images)],
                ]
            );
        }
    }
}
