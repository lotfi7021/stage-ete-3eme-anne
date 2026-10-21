<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SavFakeSeeder extends Seeder
{
    /**
     * Insère 11 tickets SAV de démonstration (table supports).
     * Idempotent : clé = (id_client, sujet).
     *
     * php artisan db:seed --class=SavFakeSeeder
     */
    public function run(): void
    {
        $clientIds = DB::table('admins')->where('role', 'client')->orderBy('id')->pluck('id')->all();

        if (count($clientIds) === 0) {
            $this->command->error('Aucun client trouvé : lancez ClientCompteFakeSeeder avant ce seeder.');
            return;
        }

        $tickets = [
            ['sujet' => 'Commande pièce non reçue',      'support' => 'commercial', 'message' => "Bonjour, ma commande du disque de frein (C-1003) n'est toujours pas livrée après 5 jours."],
            ['sujet' => 'Erreur de référence livrée',    'support' => 'technical',  'message' => "La référence reçue ne correspond pas à ma commande. Merci de procéder à l'échange."],
            ['sujet' => 'Demande de devis volume',       'support' => 'commercial', 'message' => 'Je souhaite un devis pour 50 filtres à huile et 30 plaquettes de frein.'],
            ['sujet' => 'Problème de compatibilité',     'support' => 'technical',  'message' => "L'amortisseur commandé n'est pas compatible avec le modèle de mon véhicule."],
            ['sujet' => 'Retard de livraison',           'support' => 'commercial', 'message' => 'Le colis est en retard, pouvez-vous me communiquer le numéro de suivi ?'],
            ['sujet' => 'Pièce défectueuse',             'support' => 'technical',  'message' => "L'alternateur reçu présente un défaut de charge dès l'installation."],
            ['sujet' => 'Facture manquante',             'support' => 'commercial', 'message' => "Merci de m'envoyer la facture de la commande du mois dernier."],
            ['sujet' => 'Question technique de montage', 'support' => 'technical',  'message' => "Pouvez-vous me confirmer le couple de serrage du kit d'embrayage ?"],
            ['sujet' => 'Demande de garantie',           'support' => 'commercial', 'message' => 'Je souhaite activer la garantie sur la batterie achetée il y a 2 mois.'],
            ['sujet' => 'Remplacement sous garantie',    'support' => 'technical',  'message' => 'La courroie a cassé après 1 mois, je demande un remplacement sous garantie.'],
            ['sujet' => 'Erreur de prix catalogue',      'support' => 'commercial', 'message' => "Le prix affiché sur le catalogue ne correspond pas à celui facturé."],
        ];

        foreach ($tickets as $i => $t) {
            DB::table('supports')->updateOrInsert(
                ['id_client' => $clientIds[$i % count($clientIds)], 'sujet' => $t['sujet']],
                [
                    'support'    => $t['support'],
                    'message'    => $t['message'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('11 tickets SAV insérés.');
    }
}
