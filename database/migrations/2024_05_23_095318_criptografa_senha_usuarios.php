<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriptografaSenhaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Itera sobre os registros existentes na tabela 'usuarios'
        DB::table('usuarios')->orderBy('id')->chunk(100, function ($usuarios) {
            foreach ($usuarios as $usuario) {
                // Criptografa a senha e atualiza o campo 'password' na tabela 'usuarios'
                DB::table('usuarios')
                    ->where('id', $usuario->id)
                    ->update(['password' => Hash::make($usuario->password)]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
