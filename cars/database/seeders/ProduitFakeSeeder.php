<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitFakeSeeder extends Seeder
{
    /**
     * Insère 11 pièces de rechange de démonstration + leur ligne de stock.
     * Idempotent : ré-exécutable sans créer de doublons (clé = reference).
     *
     * php artisan db:seed --class=ProduitFakeSeeder
     */
    public function run(): void
    {
        $marques = DB::table('marque_machines')->pluck('id')->all();
        $models  = DB::table('model_machines')->pluck('id')->all();

        if (empty($marques) || empty($models)) {
            $this->command->error('Aucune marque/modèle trouvé : lancez MarquesSeeder et créez des modèles avant ce seeder.');
            return;
        }

        // qte pilote le statut de stock affiché (gestion_machine/list) :
        //   0        => Rupture de stock
        //   1 à 4    => Presque fini
        //   >= 5     => En stock
        $produits = [
            ['reference' => 'C-1001', 'titre' => 'Filtre à huile moteur', 'description' => 'Filtre à huile haute filtration compatible moteurs essence et diesel.', 'image1' => '1710767166_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 45.500, 'qte' => 25],
            ['reference' => 'C-1002', 'titre' => 'Plaquettes de frein avant', 'description' => 'Jeu de plaquettes de frein avant, faible usure et freinage silencieux.', 'image1' => '1710767200_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 129.000, 'qte' => 0],
            ['reference' => 'C-1003', 'titre' => 'Disque de frein ventilé', 'description' => 'Disque de frein ventilé, résistant à la chaleur et longue durée de vie.', 'image1' => '1710767290_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 210.000, 'qte' => 2],
            ['reference' => 'C-1004', 'titre' => 'Amortisseur arrière', 'description' => 'Amortisseur arrière à gaz pour un meilleur confort et tenue de route.', 'image1' => '1710767386_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 340.000, 'qte' => 8],
            ['reference' => 'C-1005', 'titre' => 'Courroie de distribution', 'description' => 'Kit courroie de distribution avec galets tendeurs inclus.', 'image1' => '1710767426_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 275.500, 'qte' => 1],
            ['reference' => 'C-1006', 'titre' => 'Batterie 12V 70Ah', 'description' => 'Batterie sans entretien 12V - 70Ah, démarrage puissant et fiable.', 'image1' => '1710767597_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 420.000, 'qte' => 15],
            ['reference' => 'C-1007', 'titre' => "Bougies d'allumage (jeu de 4)", 'description' => "Jeu de 4 bougies d'allumage pour combustion optimale et économie de carburant.", 'image1' => '1710767697_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 96.000, 'qte' => 30],
            ['reference' => 'C-1008', 'titre' => 'Alternateur 14V', 'description' => 'Alternateur reconditionné 14V, charge stable pour tous vos équipements.', 'image1' => '1710767790_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 680.000, 'qte' => 3],
            ['reference' => 'C-1009', 'titre' => 'Radiateur de refroidissement', 'description' => 'Radiateur de refroidissement en aluminium, dissipation thermique optimale.', 'image1' => '1710771691_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 455.000, 'qte' => 9],
            ['reference' => 'C-1010', 'titre' => "Kit d'embrayage complet", 'description' => "Kit d'embrayage complet : disque, mécanisme et butée hydraulique.", 'image1' => '1711722068_pol_pl_Conti-NL-dwugrupowy-566_2.jpg', 'prix' => 890.000, 'qte' => 0],
            ['reference' => 'C-1011', 'titre' => 'Filtre à air', 'description' => 'Filtre à air plissé pour protéger le moteur des impuretés.', 'image1' => '1711724117_81siO11CjuL._AC_SL1500_.jpg', 'prix' => 58.000, 'qte' => 22],
        ];

        foreach ($produits as $i => $p) {
            DB::table('gestion_machines')->updateOrInsert(
                ['reference' => $p['reference']],
                [
                    'titre'       => $p['titre'],
                    'description' => $p['description'],
                    'image1'      => $p['image1'],
                    'prix'        => $p['prix'],
                    'qte'         => $p['qte'],
                    'marque_id'   => $marques[$i % count($marques)],
                    'model_id'    => $models[$i % count($models)],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );

            $produitId = DB::table('gestion_machines')->where('reference', $p['reference'])->value('id');

            DB::table('stock_machines')->updateOrInsert(
                ['id_produit' => $produitId],
                [
                    'qte_initial' => $p['qte'],
                    'mouvement'   => 0,
                    'qte_final'   => $p['qte'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }

        $this->command->info('11 produits de démonstration insérés (avec stock).');
    }
}
