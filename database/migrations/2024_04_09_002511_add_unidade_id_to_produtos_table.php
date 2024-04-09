<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnidadeIdToProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Adiciona a coluna unidade_id
            $table->unsignedBigInteger('unidade_id')->nullable()->after('estoque_maximo');
            // Define a chave estrangeira
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['unidade_id']);
            // Remove a coluna unidade_id
            $table->dropColumn('unidade_id');
        });
    }
}
