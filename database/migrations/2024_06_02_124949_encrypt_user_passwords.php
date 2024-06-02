<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EncryptUserPasswords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    }
}
