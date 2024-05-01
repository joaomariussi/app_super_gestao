<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\LoginController;
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

Route::get('/fornecedor', [FornecedorController::class, 'index'])->name('app.fornecedor');
Route::get('/fornecedor/search', [FornecedorController::class, 'search'])->name('app.fornecedor.search');
Route::any('/fornecedor/adicionar', [FornecedorController::class, 'adicionar'])->name('app.fornecedor.adicionar');
Route::post('/fornecedor/editar/{id}', [FornecedorController::class, 'editar'])->name('app.fornecedor.editar');
Route::post('/fornecedor/excluir/{id}', [FornecedorController::class, 'excluir'])->name('app.fornecedor.excluir');

Route::get('/produto', [ProdutoController::class, 'index'])->name('app.produto');
Route::any('/produto/adicionar', [ProdutoController::class, 'adicionar'])->name('app.produto.adicionar');
Route::post('/produto/editar/{id}', [ProdutoController::class, 'editar'])->name('app.produto.editar');
Route::post('/produto/excluir/{id}', [ProdutoController::class, 'excluir'])->name('app.produto.excluir');
Route::get('/produto/visualizar', [ProdutoController::class, 'visualizar'])->name('app.produto.visualizar');

Route::get('/cliente', [ClienteController::class, 'index'])->name('app.cliente.index');
Route::any('/cliente/adicionar', [ClienteController::class, 'adicionar'])->name('app.cliente.adicionar');
Route::post('/cliente/editar/{id}', [ClienteController::class, 'editar'])->name('app.cliente.editar');
Route::post('/cliente/excluir/{id}', [ClienteController::class, 'excluir'])->name('app.cliente.excluir');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');


Route::fallback(function () {
    echo 'A rota acessada não existe.
    <a href="'.route('site.principal').'">Clique aqui</a> para ir para a página inicial';
});


