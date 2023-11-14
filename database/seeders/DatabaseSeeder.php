<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //Users
        // Exemplo de inserção de usuário
        DB::table('users')->insert([
            'name' => 'MiilkShayk',
            'email' => 'miilkshayk@gmail.com',
            'password' => bcrypt('senha123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
