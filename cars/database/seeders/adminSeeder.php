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
            'nom' => Str::random(10),
            'type' => '1',
            'login' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        DB::table('admins')->insert([
            'nom' => Str::random(10),
            'type' => '1',
            'login' => 'user',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);
        DB::table('admins')->insert([
            'nom' => Str::random(10),
            'type' => '1',
            'login' => 'livreur',
            'role' => 'livreur',
            'password' => Hash::make('password'),
        ]);

    }
}
