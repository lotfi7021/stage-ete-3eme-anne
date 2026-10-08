<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class:adminSeeder
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'nom' => 'Administrateur',
            'prenom' => 'Principal',
            'type' => '1',
            'login' => 'admin',
            'role' => 'admin',
            'status' => 1,
            'groupe' => 0,
            'nom_de_la_societe' => 'Cars Admin',
            'code_TVA' => '',
            'adresse' => '',
            'telephone' => 0,
            'Email' => 'admin@cars.com',
            'region' => '',
            'password' => Hash::make('password'),
        ]);

        DB::table('admins')->insert([
            'nom' => 'Utilisateur',
            'prenom' => 'Client',
            'type' => '1',
            'login' => 'user',
            'role' => 'client',
            'status' => 1,
            'groupe' => 0,
            'nom_de_la_societe' => 'Client Test',
            'code_TVA' => '',
            'adresse' => '',
            'telephone' => 0,
            'Email' => 'user@cars.com',
            'region' => '',
            'password' => Hash::make('password'),
        ]);
        
        DB::table('admins')->insert([
            'nom' => 'Livreur',
            'prenom' => 'Test',
            'type' => '1',
            'login' => 'livreur',
            'role' => 'livreur',
            'status' => 1,
            'groupe' => 0,
            'nom_de_la_societe' => 'Livreur Test',
            'code_TVA' => '',
            'adresse' => '',
            'telephone' => 0,
            'Email' => 'livreur@cars.com',
            'region' => '',
            'password' => Hash::make('password'),
        ]);
    }
}
