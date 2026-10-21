<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientCompteFakeSeeder extends Seeder
{
    /**
     * Insère 11 comptes clients de démonstration (role = 'client').
     *
     * Ces lignes alimentent à la fois :
     *   - la liste « Clients »      (admins.role = 'client')
     *   - la liste « des comptes »  (admins.status = 1, tous rôles)
     *
     * Idempotent : ré-exécutable sans doublons (clé = login).
     *
     * php artisan db:seed --class=ClientCompteFakeSeeder
     */
    public function run(): void
    {
        $plainPassword = env('SEED_CLIENT_PASSWORD') ?: 'Client#Cars2026';
        $hash = Hash::make($plainPassword);

        $clients = [
            ['nom' => 'Ben Salah', 'prenom' => 'Ahmed',  'ste' => 'Société Auto Pièces Tunis', 'tva' => '0012345/A/M/000', 'adresse' => '12 Rue de Rome, Tunis',        'tel' => 71234567, 'email' => 'contact@autopieces.tn',     'region' => 'Tunis',   'login' => 'client01'],
            ['nom' => 'Trabelsi',  'prenom' => 'Sami',   'ste' => 'Garage Central Sfax',       'tva' => '0023456/B/M/000', 'adresse' => 'Av. Habib Bourguiba, Sfax',    'tel' => 74234567, 'email' => 'sami.trabelsi@gcsf.tn',     'region' => 'Sfax',    'login' => 'client02'],
            ['nom' => 'Bouazizi',  'prenom' => 'Leila',  'ste' => 'Pièces Express Sousse',     'tva' => '0034567/C/M/000', 'adresse' => 'Rue du Maghreb Arabe, Sousse', 'tel' => 73245678, 'email' => 'leila@piecesexpress.tn',    'region' => 'Sousse',  'login' => 'client03'],
            ['nom' => 'Gharbi',    'prenom' => 'Karim',  'ste' => 'Mécanique Plus Ariana',     'tva' => '0045678/D/M/000', 'adresse' => 'Av. Taieb Mhiri, Ariana',      'tel' => 71256789, 'email' => 'karim@mecaplus.tn',         'region' => 'Ariana',  'login' => 'client04'],
            ['nom' => 'Mejri',     'prenom' => 'Nadia',  'ste' => 'Auto Services Nabeul',      'tva' => '0056789/E/M/000', 'adresse' => 'Av. de la Plage, Nabeul',      'tel' => 72267890, 'email' => 'nadia@autoservices.tn',     'region' => 'Nabeul',  'login' => 'client05'],
            ['nom' => 'Chaabane',  'prenom' => 'Yassine','ste' => 'Dépôt Auto Monastir',       'tva' => '0067890/F/M/000', 'adresse' => 'Rue Ibn El Jazzar, Monastir',  'tel' => 73578901, 'email' => 'yassine@depotauto.tn',      'region' => 'Monastir','login' => 'client06'],
            ['nom' => 'Khelifi',   'prenom' => 'Rim',    'ste' => 'Tunisie Pieces Auto',       'tva' => '0078901/G/M/000', 'adresse' => 'Bd 7 Novembre, Tunis',         'tel' => 71489012, 'email' => 'rim@tunisiepieces.tn',      'region' => 'Tunis',   'login' => 'client07'],
            ['nom' => 'Zouari',    'prenom' => 'Mehdi',  'ste' => 'Sfax Auto Parts',           'tva' => '0089012/H/M/000', 'adresse' => 'Route de Gabès, Sfax',         'tel' => 74490123, 'email' => 'mehdi@sfaxautoparts.tn',    'region' => 'Sfax',    'login' => 'client08'],
            ['nom' => 'Ben Amor',  'prenom' => 'Ines',   'ste' => 'Bizerte Motors',            'tva' => '0090123/I/M/000', 'adresse' => 'Av. de la République, Bizerte','tel' => 72501234, 'email' => 'ines@bizertemotors.tn',     'region' => 'Bizerte', 'login' => 'client09'],
            ['nom' => 'Kacem',     'prenom' => 'Farouk', 'ste' => 'Gabès Pièces Service',      'tva' => '0101234/J/M/000', 'adresse' => 'Rue de Mareth, Gabès',         'tel' => 75312345, 'email' => 'farouk@gabespieces.tn',     'region' => 'Gabès',   'login' => 'client10'],
            ['nom' => 'Saidi',     'prenom' => 'Amine',  'ste' => 'Djerba Auto Center',        'tva' => '0112345/K/M/000', 'adresse' => 'Zone Touristique, Djerba',     'tel' => 75623456, 'email' => 'amine@djerbaauto.tn',       'region' => 'Médenine','login' => 'client11'],
        ];

        foreach ($clients as $c) {
            DB::table('admins')->updateOrInsert(
                ['login' => $c['login']],
                [
                    'nom'              => $c['nom'],
                    'prenom'           => $c['prenom'],
                    'type'             => '1',
                    'role'             => 'client',
                    'status'           => 1,
                    'groupe'           => 0,
                    'nom_de_la_societe'=> $c['ste'],
                    'code_TVA'         => $c['tva'],
                    'adresse'          => $c['adresse'],
                    'telephone'        => $c['tel'],
                    'Email'            => $c['email'],
                    'region'           => $c['region'],
                    'password'         => $hash,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );
        }

        $this->command->info('11 comptes clients insérés (mot de passe : ' . $plainPassword . ').');
    }
}
