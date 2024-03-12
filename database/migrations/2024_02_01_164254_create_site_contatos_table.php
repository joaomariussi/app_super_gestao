<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_contatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('telefone', 20);
            $table->string('email', 100);
            $table->unsignedBigInteger('motivo_contato_id');
            $table->text('mensagem');
            $table->timestamps();

            // Relacionamento com a tabela motivo_contatos
            $table->foreign('motivo_contato_id')->references('id')->on('motivos_contatos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_contatos');
    }
}
