<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->text('descricao');
            $table->string('codigo');
            $table->unsignedBigInteger('unidade_id');
            $table->unsignedBigInteger('id_fornecedor');
            $table->float('preco_venda', 8, 2)->default(0.01);
            $table->integer('quantidade');
            $table->float('peso', 8, 2);
            $table->float('largura')->nullable();
            $table->float('comprimento')->nullable();
            $table->float('altura')->nullable();
            $table->timestamps();

            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign(['unidade_id']);
            $table->dropForeign(['id_fornecedor']);
        });

        Schema::dropIfExists('produtos');
    }
}
