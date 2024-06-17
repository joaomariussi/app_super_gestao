<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MotivosContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('motivos_contatos')->insert([
            'motivo' => 'Dúvida',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('motivos_contatos')->insert([
            'motivo' => 'Suporte',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('motivos_contatos')->insert([
            'motivo' => 'Reclamação',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('motivos_contatos')->insert([
            'motivo' => 'Outras informações',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
