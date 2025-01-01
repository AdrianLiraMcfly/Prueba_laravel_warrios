<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GrupoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Rutas de grupos */
Route::get('/', [GrupoController::class, 'index'])->name('grupos.index');
Route::post('/grupos', [GrupoController::class, 'create'])->name('grupos.create');
Route::put('/grupos/{id}', [GrupoController::class, 'update'])->name('grupos.update')->where('id', '[0-9]+');
Route::delete('/grupos/{id}', [GrupoController::class, 'delete'])->name('grupos.delete')->where('id', '[0-9]+');
Route::get('/grupos/{id}', [GrupoController::class, 'show'])->name('grupos.show')->where('id', '[0-9]+');

/*Rutas de Estudiantes */
Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
Route::post('/estudiantes', [EstudianteController::class, 'create'])->name('estudiantes.create');
Route::put('/estudiantes/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update')->where('id', '[0-9]+');
Route::delete('/estudiantes/{id}', [EstudianteController::class, 'delete'])->name('estudiantes.delete')->where('id', '[0-9]+');
