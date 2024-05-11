<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdClienteToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Exclui a coluna id_pedido
            $table->dropColumn('id_pedido');

            // Adiciona a coluna id_cliente após a coluna id
            $table->unsignedBigInteger('id_cliente')->after('id');

            // Define a chave estrangeira
            $table->foreign('id_cliente')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Recria a coluna id_pedido
            $table->bigIncrements('id_pedido');

            // Remove a coluna id_cliente
            $table->dropForeign(['id_cliente']);
            $table->dropColumn('id_cliente');
        });
    }
}
