<?php


use Database\Seeders\MotivosContatoSeeder;
use Database\Seeders\UnidadesSeeder;
use Database\Seeders\UsuariosSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UsuariosSeeder::class);

        $this->call(UnidadesSeeder::class);

        $this->call(MotivosContatoSeeder::class);
    }
}
