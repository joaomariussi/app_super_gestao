<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'nome' => 'João Pedro Mariussi',
            'email' => 'teste@gmail.com',
            'password' => Hash::make('123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
