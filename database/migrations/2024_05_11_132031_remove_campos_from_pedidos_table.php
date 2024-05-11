<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCamposFromPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remover a chave estrangeira
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign('pedido_produtos_id_produto_foreign');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('id_produto');
            $table->dropColumn('nome_produto');
            $table->dropColumn('valor_produto');
            $table->dropColumn('quantidade');
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
            //
        });
    }
}
