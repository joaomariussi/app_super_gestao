<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProdutosRelacionamentoFornecedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->unsignedBigInteger('fornecedor_id')->nullable()->after('id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
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
            $table->unsignedBigInteger('fornecedor_id')->nullable()->after('id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }
}
