<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesPedidosProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cfp', 11);
            $table->string('email', 100);
            $table->timestamps();
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes');
        });

        Schema::create('pedido_produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_produto');
            $table->string('nome_produto', 100);
            $table->decimal('valor_produto', 10, 2);
            $table->timestamps();

            $table->foreign('id_pedido')->references('id')->on('pedidos');
            $table->foreign('id_produto')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('pedido_produtos');
        Schema::enableForeignKeyConstraints();
    }
}
