<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JogadoresController;
use App\Http\Controllers\SorteiosController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/jogadores', [JogadoresController::class, 'index'])->name('jogadores');
Route::get('/jogadores/manage/{id?}', [JogadoresController::class, 'manage'])->name('jogadores.manage');
Route::post('/jogadores/save', [JogadoresController::class, 'save'])->name('jogadores.save');
Route::post('/jogadores/delete/{id}', [JogadoresController::class, 'delete'])->name('jogadores.delete');
Route::get('/jogadores/deleteAll', [JogadoresController::class, 'deleteAll'])->name('jogadores.deleteAll');
Route::get('/jogadores/criarJogadoresFicticios', [JogadoresController::class, 'criarJogadoresFicticios'])->name('jogadores.criarJogadoresFicticios');

Route::get('/sorteios', [SorteiosController::class, 'index'])->name('sorteios');
