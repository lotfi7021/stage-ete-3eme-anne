<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarquesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marques')->insert([
            'titre' =>'BMW',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marques')->insert([
            'titre' =>'Citroën',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marques')->insert([
            'titre' =>'Ford',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marques')->insert([
            'titre' =>'Peugeot',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marques')->insert([
            'titre' =>'Renault',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marques')->insert([
            'titre' =>'Fiat',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
