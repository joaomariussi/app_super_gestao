<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfProductDimensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Alterando a coluna peso
            $table->integer('peso')->change();
            // Alterando a coluna largura
            $table->integer('largura')->change();
            // Alterando a coluna comprimento
            $table->integer('comprimento')->change();
            // Alterando a coluna altura
            $table->integer('altura')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Reverter as alterações (opcional)
            $table->decimal('peso', 10, 2)->change();
            $table->decimal('largura', 10, 2)->change();
            $table->decimal('comprimento', 10, 2)->change();
            $table->decimal('altura', 10, 2)->change();
        });
    }
}
