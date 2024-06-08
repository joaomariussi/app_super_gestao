<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SobreNosController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [PrincipalController::class, 'index'])->name('site.principal');
    Route::get('/sobre-nos', [SobreNosController::class, 'sobreNos'])->name('site.sobrenos');
    Route::get('/contato', [ContatoController::class, 'contato'])->name('site.contato');
    Route::post('/contato', [ContatoController::class, 'salvar'])->name('site.contato');
});


Route::group(['prefix' => '/fornecedor'], function () {
    Route::get('/', [FornecedorController::class, 'index'])->name('app.fornecedor');
    Route::get('/adicionar', [FornecedorController::class, 'adicionar'])->name('app.fornecedor.adicionar');
    Route::post('/adicionar', [FornecedorController::class, 'adicionar'])->name('app.fornecedor.salvar');
    Route::get('/editar/{id}', [FornecedorController::class, 'editar'])->name('app.fornecedor.editar');
    Route::post('/editar/{id}', [FornecedorController::class, 'atualizar'])->name('app.fornecedor.atualizar');
    Route::post('/excluir/{id}', [FornecedorController::class, 'excluir'])->name('app.fornecedor.excluir');
});

Route::group(['prefix' => '/produto'], function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('app.produto');
    Route::get('/adicionar', [ProdutoController::class, 'adicionar'])->name('app.produto.adicionar');
    Route::post('/adicionar', [ProdutoController::class, 'adicionar'])->name('app.produto.salvar');
    Route::get('/visualizar/{id}', [ProdutoController::class, 'visualizar'])->name('app.produto.visualizar');
    Route::get('/editar/{id}', [ProdutoController::class, 'editar'])->name('app.produto.editar');
    Route::post('/editar/{id}', [ProdutoController::class, 'editar'])->name('app.produto.editar');
    Route::delete('/excluir/{id}', [ProdutoController::class, 'excluir'])->name('app.produto.excluir');
});

Route::get('produtos', [PedidoController::class, 'buscaProdutos'])->name('app.pedido.produtos');

Route::group(['prefix' => '/cliente'], function () {
    Route::get('/', [ClienteController::class, 'index'])->name('app.cliente');
    Route::get('/adicionar', [ClienteController::class, 'adicionar'])->name('app.cliente.adicionar');
    Route::post('/adicionar', [ClienteController::class, 'adicionar'])->name('app.cliente.salvar');
    Route::get('/editar/{id}', [ClienteController::class, 'editar'])->name('app.cliente.editar');
    Route::post('/editar/{id}', [ClienteController::class, 'atualizar'])->name('app.cliente.atualizar');
    Route::post('/excluir/{id}', [ClienteController::class, 'excluir'])->name('app.cliente.excluir');
});

Route::post('/verifica-cpf', [ClienteController::class, 'verificaCpf'])->name('app.cliente.verifica-cpf');
Route::post('/verifica-email', [ClienteController::class, 'verificaEmail'])->name('app.cliente.verifica-email');

Route::group(['prefix' => '/pedido'], function () {
    Route::get('/', [PedidoController::class, 'index'])->name('app.pedido');
    Route::get('/adicionar', [PedidoController::class, 'adicionar'])->name('app.pedido.adicionar');
    Route::post('/adicionar', [PedidoController::class, 'adicionar'])->name('app.pedido.salvar');
    Route::get('visualizar/{id}', [PedidoController::class, 'visualizar'])->name('app.pedido.visualizar');
    Route::delete('/excluir/{id}', [PedidoController::class, 'excluir'])->name('app.pedido.excluir');
    Route::get('pedido/{id}/pdf', [PedidoController::class, 'gerarPdf'])->name('app.pedido.pdf');
});

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::fallback(function () {
    echo 'A rota acessada não existe.
    <a href="'.route('site.principal').'">Clique aqui</a> para ir para a página inicial';
});


