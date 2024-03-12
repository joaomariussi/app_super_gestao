<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [PrincipalController::class, 'index'])->name('site.principal');
    Route::get('/sobre-nos', 'SobreNosController@sobreNos')->name('site.sobrenos');
    Route::get('/contato', 'ContatoController@contato')->name('site.contato');
    Route::post('/contato', 'ContatoController@salvar')->name('site.contato');
    // Outras rotas que precisam de autenticação...
});

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::prefix('/app')->middleware('auth')->group(function () {
    Route::get('/clientes', function () { return 'Clientes'; })->name('app.clientes');
    Route::get('/fornecedores', 'FornecedorController@index')->name('app.fornecedores');
    Route::get('/produtos', function () { return 'Produtos'; })->name('app.produtos');
});

Route::fallback(function () {
    echo 'A rota acessada não existe. <a href="'.route('site.principal').'">Clique aqui</a> para ir para a página inicial';
});


