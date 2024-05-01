<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunasTableClietes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('telefone', 20)->nullable()->after('email');
            $table->string('endereco', 255)->nullable()->after('telefone');
            $table->string('cep', 10)->nullable()->after('endereco');
            $table->string('estado', 50)->nullable()->after('cep');
            $table->string('cidade', 100)->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('telefone');
            $table->dropColumn('endereco');
            $table->dropColumn('cep');
            $table->dropColumn('estado');
            $table->dropColumn('cidade');
        });
    }
}
