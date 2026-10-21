<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CommandeFakeSeeder extends Seeder
{
    /**
     * Insère 16 commandes de démonstration + leurs lignes de détail.
     * Chaque client reçoit au moins une commande pour que « Mes commandes »
     * ne soit pas vide côté interface client.
     * Idempotent : clé = ref_commande (les lignes de détail sont recréées).
     *
     * php artisan db:seed --class=CommandeFakeSeeder
     */
    public function run(): void
    {
        $clientIds  = DB::table('admins')->where('role', 'client')->orderBy('id')->pluck('id')->all();
        $livreurIds = DB::table('admins')->where('role', 'livreur')->orderBy('id')->pluck('id')->all();
        $produits   = DB::table('gestion_machines')->get(['id', 'prix'])->all();

        if (count($clientIds) === 0 || count($produits) === 0) {
            $this->command->error('Clients ou produits manquants : lancez ClientCompteFakeSeeder et ProduitFakeSeeder avant.');
            return;
        }

        $etats    = ['en attente', 'confirmée', 'Livrée'];
        $paiements = ['0', '50', '20'];
        $nb = 16;

        for ($i = 0; $i < $nb; $i++) {
            $ref      = 'cmd-demo-' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
            $clientId = $clientIds[$i % count($clientIds)];
            $etat     = $etats[$i % count($etats)];
            $livreur  = $etat === 'en attente' ? 0 : ($livreurIds ? $livreurIds[$i % count($livreurIds)] : 0);

            // 1 à 2 lignes de détail par commande
            $nbLignes = 1 + ($i % 2);
            $total = 0;
            $lignes = [];
            for ($j = 0; $j < $nbLignes; $j++) {
                $p   = $produits[($i + $j) % count($produits)];
                $qte = 1 + (($i + $j) % 3);
                $total += $p->prix * $qte;
                $lignes[] = ['id_produit' => $p->id, 'prix' => $p->prix, 'qte' => $qte];
            }

            DB::table('commande__m_s')->updateOrInsert(
                ['ref_commande' => $ref],
                [
                    'id_client'      => $clientId,
                    'prix'           => $total,
                    'tva'            => $total * 1.19,
                    'date_livraison' => Carbon::now()->addDays(2 + ($i % 7))->toDateString(),
                    'title'          => $ref,
                    'start'          => Carbon::now()->toDateTimeString(),
                    'end'            => Carbon::now()->addHour()->toDateTimeString(),
                    'id_livreur'     => $livreur,
                    'etat'           => $etat,
                    'paiement'       => $paiements[$i % count($paiements)],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );

            DB::table('detail_commande_m_s')->where('ref_commande', $ref)->delete();
            foreach ($lignes as $l) {
                DB::table('detail_commande_m_s')->insert([
                    'ref_commande' => $ref,
                    'id_produit'   => $l['id_produit'],
                    'prix'         => $l['prix'],
                    'qte'          => $l['qte'],
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        $this->command->info($nb . ' commandes de démonstration insérées (avec lignes de détail).');
    }
}
