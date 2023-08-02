<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
Route::get('/user', [UserController::class, 'list'])->name('users.list');

Route::get('/cidades', [CidadeController::class, 'list'])->name('cidades.list');

Route::group(
    ['prefix' => 'medicos'],
    function () {
        Route::get('', [MedicoController::class, 'list'])->name('medicos.list');
    }
);
