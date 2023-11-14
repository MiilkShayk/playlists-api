<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MusicaSeeder extends Seeder
{
    public function run()
    {
        // Authors
        DB::table('authors')->insert([
            'name' => 'Caravan Palace',
        ]);
        DB::table('authors')->insert([
            'name' => 'Parov Stelar',
        ]);
        DB::table('authors')->insert([
            'name' => 'Alan Walker',
        ]);

        // Categoria de Musicas
        DB::table('musica_categories')->insert([
            'name' => 'Electro Swing',
        ]);
        DB::table('musica_categories')->insert([
            'name' => 'ElectroPop',
        ]);

        // Musicas
        DB::table('musicas')->insert([
            'name' => 'Caraval Palace - Dramphone',
            'authors_id' => 1,
            'categories_id' => 1,
        ]);
        DB::table('musicas')->insert([
            'name' => 'Parov Stelar - Booty Swing',
            'authors_id' => 2,
            'categories_id' => 1,
        ]);
        DB::table('musicas')->insert([
            'name' => 'Alan Walker - On My Way',
            'authors_id' => 3,
            'categories_id' => 2,
        ]);
    }
}
