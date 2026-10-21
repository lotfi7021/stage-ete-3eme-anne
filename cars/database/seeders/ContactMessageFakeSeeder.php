<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactMessageFakeSeeder extends Seeder
{
    /**
     * Insère 12 messages de contact de démonstration (table contacts).
     * Ce sont des demandes de prospects : créer un compte, partenariat
     * fournisseur / livreur, devenir revendeur, etc.
     * Idempotent : clé = email.
     *
     * php artisan db:seed --class=ContactMessageFakeSeeder
     */
    public function run(): void
    {
        $messages = [
            ['nom' => 'Ahmed Ben Salah',  'email' => 'contact@autopieces.tn',  'telephone' => '71234567', 'sujet' => 'Je veux créer un compte avec vous',                 'contenu' => 'Bonjour, je souhaite créer un compte client pour commander des pièces détachées. Quelles sont les démarches et les conditions requises ?'],
            ['nom' => 'Sami Trabelsi',    'email' => 'sami.trabelsi@gcsf.tn',  'telephone' => '74234567', 'sujet' => "J'ai un fournisseur, je veux travailler avec vous", 'contenu' => 'Bonjour, je travaille avec un fournisseur de pièces auto et je souhaite référencer ses produits sur votre plateforme. Qui dois-je contacter ?'],
            ['nom' => 'Leila Bouazizi',   'email' => 'leila@piecesexpress.tn', 'telephone' => '73245678', 'sujet' => "J'ai un livreur, je veux travailler avec vous",     'contenu' => 'Bonjour, je dispose d\'un service de livraison et je souhaite devenir votre partenaire logistique. Comment procéder ?'],
            ['nom' => 'Karim Gharbi',     'email' => 'karim@mecaplus.tn',      'telephone' => '71256789', 'sujet' => 'Devenir revendeur agréé',                           'contenu' => 'Bonjour, je tiens un garage et je souhaite devenir revendeur agréé de vos produits. Quelles sont les conditions ?'],
            ['nom' => 'Nadia Mejri',      'email' => 'nadia@autoservices.tn',  'telephone' => '72267890', 'sujet' => 'Ouvrir un compte professionnel',                    'contenu' => 'Bonjour, je souhaite ouvrir un compte professionnel pour ma société. Pouvez-vous m\'indiquer les pièces à fournir ?'],
            ['nom' => 'Yassine Chaabane', 'email' => 'yassine@depotauto.tn',   'telephone' => '73578901', 'sujet' => 'Je veux travailler avec vous comme livreur',        'contenu' => 'Bonjour, je suis livreur indépendant et je souhaite rejoindre votre réseau de livraison. Quelles sont les démarches ?'],
            ['nom' => 'Rim Khelifi',      'email' => 'rim@tunisiepieces.tn',   'telephone' => '71489012', 'sujet' => 'Partenariat fournisseur de pièces détachées',       'contenu' => 'Bonjour, nous sommes fabricant de pièces détachées et nous souhaitons collaborer avec vous. Merci de nous recontacter.'],
            ['nom' => 'Mehdi Zouari',     'email' => 'mehdi@sfaxautoparts.tn', 'telephone' => '74490123', 'sujet' => 'Créer un compte client en ligne',                    'contenu' => 'Bonjour, j\'aimerais créer un compte client en ligne pour consulter vos tarifs et passer mes commandes. Merci.'],
            ['nom' => 'Ines Ben Amor',    'email' => 'ines@bizertemotors.tn',  'telephone' => '72501234', 'sujet' => "J'ai des clients, je veux travailler avec vous",    'contenu' => 'Bonjour, je gère une flotte de véhicules et je cherche un partenaire pour l\'approvisionnement en pièces. Souhaitez-vous collaborer ?'],
            ['nom' => 'Farouk Kacem',     'email' => 'farouk@gabespieces.tn',  'telephone' => '75312345', 'sujet' => 'Demande d\'ouverture de compte revendeur',          'contenu' => 'Bonjour, je souhaite ouvrir un compte revendeur pour acheter vos pièces en gros. Quelles sont vos conditions tarifaires ?'],
            ['nom' => 'Amine Saidi',      'email' => 'amine@djerbaauto.tn',    'telephone' => '75623456', 'sujet' => 'Je veux devenir partenaire livreur',                'contenu' => 'Bonjour, je propose un service de livraison rapide et je souhaite devenir l\'un de vos partenaires livreurs. Merci.'],
            ['nom' => 'Hedi Mansouri',    'email' => 'hedi@mansouria.auto',    'telephone' => '71567890', 'sujet' => 'Proposition de collaboration',                      'contenu' => 'Bonjour, je représente une société de logistique et je souhaite proposer une collaboration pour vos livraisons. Disponible pour en discuter.'],
        ];

        foreach ($messages as $m) {
            DB::table('contacts')->updateOrInsert(
                ['email' => $m['email']],
                [
                    'nom'        => $m['nom'],
                    'telephone'  => $m['telephone'],
                    'sujet'      => $m['sujet'],
                    'contenu'    => $m['contenu'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('12 messages de contact (prospects) insérés.');
    }
}
