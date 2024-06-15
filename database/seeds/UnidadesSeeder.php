<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('unidades')->insert([
            'unidade' => 'KG',
            'descricao' => 'Quilograma',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('unidades')->insert([
            'unidade' => 'LT',
            'descricao' => 'Litro',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('unidades')->insert([
            'unidade' => 'UN',
            'descricao' => 'Unidade',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('unidades')->insert([
            'unidade' => 'PC',
            'descricao' => 'Peça',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
