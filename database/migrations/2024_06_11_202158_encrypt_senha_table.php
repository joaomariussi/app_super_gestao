<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EncryptSenhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Obtém todos os usuários
        $usuarios = DB::table('usuarios')->get();

        foreach ($usuarios as $usuario) {
            // Criptografa o password
            $encryptedPassword = Hash::make($usuario->password);

            // Atualiza o password criptografado no banco de dados
            DB::table('usuarios')
                ->where('id', $usuario->id)
                ->update(['password' => $encryptedPassword]);
        }
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
