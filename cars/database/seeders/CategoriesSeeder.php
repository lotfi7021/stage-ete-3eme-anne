<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'titre' =>'Camion',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('categories')->insert([
            'titre' =>'Fourgon',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categories')->insert([
            'titre' =>'Bus et Mini Bus',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categories')->insert([
            'titre' =>'Fourgonnette',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categories')->insert([
            'titre' =>'Pick-up',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categories')->insert([
            'titre' =>'Voiture société',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categories')->insert([
            'titre' =>'Commerciale',
            'image' =>'',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
