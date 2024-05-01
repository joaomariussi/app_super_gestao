<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunasToProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produto', function (Blueprint $table) {
            // Adiciona os campos de largura, comprimento e altura
            $table->float('largura')->after('unidade_id')->nullable();
            $table->float('comprimento')->after('largura')->nullable();
            $table->float('altura')->after('comprimento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produto', function (Blueprint $table) {
            // Adiciona os campos de largura, comprimento e altura
            $table->float('largura')->after('unidade_id')->nullable();
            $table->float('comprimento')->after('largura')->nullable();
            $table->float('altura')->after('comprimento')->nullable();
        });
    }
}
