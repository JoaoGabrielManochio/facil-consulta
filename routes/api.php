<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
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

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
Route::get('/user', [UserController::class, 'list'])->name('users.list');

Route::group(
    ['prefix' => 'cidades'],
    function () {
        Route::get('', [CidadeController::class, 'list'])->name('cidades.list');
        Route::get(
            '/{cidade_id}/medicos',
            [
                MedicoController::class, 'listDoctorByCidadeId'
            ]
        )->name('cidades.listDoctorByCidadeId');
    }
);

Route::group(
    ['prefix' => 'medicos'],
    function () {
        Route::get('', [MedicoController::class, 'list'])->name('medicos.list');
        Route::middleware('auth:api')->post('', [MedicoController::class, 'store'])->name('medicos.store');
        Route::middleware('auth:api')->post(
            '{medico_id}/pacientes',
            [
                MedicoController::class, 'storePacientToDoctor'
            ]
        )->name('medicos.storePacientToDoctor');
        Route::middleware('auth:api')->get(
            '{medico_id}/pacientes',
            [
                PacienteController::class, 'listPacientByMedicoId'
            ]
        )->name('medicos.listPacientDoctor');
    }
);
