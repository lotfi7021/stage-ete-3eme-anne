<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class adminSeeder extends Seeder
{
    /**
     * Crée (ou met à jour) les comptes de démonstration avec des mots de passe forts.
     *
     * Le mot de passe est lu depuis l'environnement (SEED_*_PASSWORD) ; s'il n'est
     * pas défini, un mot de passe aléatoire est généré et affiché une seule fois.
     *
     * php artisan db:seed --class=adminSeeder
     */
    public function run(): void
    {
        $accounts = [
            [
                'login' => 'admin', 'role' => 'admin',
                'nom' => 'Administrateur', 'prenom' => 'Principal',
                'nom_de_la_societe' => 'Cars Admin', 'Email' => 'admin@cars.com',
                'env' => 'SEED_ADMIN_PASSWORD',
            ],
            [
                'login' => 'user', 'role' => 'client',
                'nom' => 'Utilisateur', 'prenom' => 'Client',
                'nom_de_la_societe' => 'Client Test', 'Email' => 'user@cars.com',
                'env' => 'SEED_CLIENT_PASSWORD',
            ],
            [
                'login' => 'livreur', 'role' => 'livreur',
                'nom' => 'Livreur', 'prenom' => 'Test',
                'nom_de_la_societe' => 'Livreur Test', 'Email' => 'livreur@cars.com',
                'env' => 'SEED_LIVREUR_PASSWORD',
            ],
        ];

        foreach ($accounts as $account) {
            $plain = env($account['env']) ?: Str::password(16);

            DB::table('admins')->updateOrInsert(
                ['login' => $account['login']],
                [
                    'nom' => $account['nom'],
                    'prenom' => $account['prenom'],
                    'type' => '1',
                    'role' => $account['role'],
                    'status' => 1,
                    'groupe' => 0,
                    'nom_de_la_societe' => $account['nom_de_la_societe'],
                    'code_TVA' => '',
                    'adresse' => '',
                    'telephone' => 0,
                    'Email' => $account['Email'],
                    'region' => '',
                    'password' => Hash::make($plain),
                ]
            );

            $this->command->warn("Compte « {$account['login']} » ({$account['role']}) → mot de passe : {$plain}");
        }
    }
}
