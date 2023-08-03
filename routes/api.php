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
            '/{id_cidade}/medicos',
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

        Route::group(
            [
                'middleware' => ['auth:api']
            ],
            function () {
                Route::post('', [MedicoController::class, 'store'])->name('medicos.store');

                Route::post(
                    '{id_medico}/pacientes',
                    [MedicoController::class, 'storePacientToDoctor']
                )->name('medicos.storePacientToDoctor');

                Route::get(
                    '{id_medico}/pacientes',
                    [PacienteController::class, 'listPatientByMedicoId']
                )->name('medicos.listPacientDoctor');
            }
        );
    }
);

Route::group(
    [
        'prefix' => 'pacientes',
        'middleware' => ['auth:api']
    ],
    function () {
        Route::post('', [PacienteController::class, 'store'])->name('pacientes.store');
        Route::put('{id_paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
    }
);
