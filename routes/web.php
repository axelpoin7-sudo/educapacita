<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// 0. Portada Pública
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 1. Página Pública de Presentación del Proyecto
Route::get('/presentacion', function () {
    return view('presentacion');
})->name('presentacion');

// 2. Rutas de Autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// 3. Rutas Protegidas del Sistema (Requieren Autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =========================================================================
    // ACCIONES EXCLUSIVAS PARA ADMINISTRADOR (es_admin = true)
    // Se declaran antes de los parámetros dinámicos {id} para evitar colisiones
    // =========================================================================
    Route::middleware('admin')->group(function () {
        // Cursos (creación, edición y eliminación)
        Route::get('cursos/create', [CursoController::class, 'create'])->name('cursos.create');
        Route::post('cursos', [CursoController::class, 'store'])->name('cursos.store');
        Route::get('cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
        Route::put('cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
        Route::delete('cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');
        Route::post('admin/ejecutar-seeders', function () {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            return back()->with('exito', '¡Datos de prueba y cursos cargados exitosamente!');
        })->name('admin.ejecutar_seeders');

        // Paralelos (apertura, edición y eliminación)
        Route::get('paralelos/create', [ParaleloController::class, 'create'])->name('paralelos.create');
        Route::post('paralelos', [ParaleloController::class, 'store'])->name('paralelos.store');
        Route::get('paralelos/{paralelo}/edit', [ParaleloController::class, 'edit'])->name('paralelos.edit');
        Route::put('paralelos/{paralelo}', [ParaleloController::class, 'update'])->name('paralelos.update');
        Route::delete('paralelos/{paralelo}', [ParaleloController::class, 'destroy'])->name('paralelos.destroy');

        // Instructores (registro, edición y eliminación)
        Route::get('instructores/create', [InstructorController::class, 'create'])->name('instructores.create');
        Route::post('instructores', [InstructorController::class, 'store'])->name('instructores.store');
        Route::get('instructores/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructores.edit');
        Route::put('instructores/{instructor}', [InstructorController::class, 'update'])->name('instructores.update');
        Route::delete('instructores/{instructor}', [InstructorController::class, 'destroy'])->name('instructores.destroy');

        // Categorías (creación, edición y eliminación)
        Route::get('categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
        Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
        Route::get('categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
        Route::put('categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
        Route::delete('categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

        // Participantes (edición y eliminación administrativa)
        Route::get('participantes/{participante}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');
        Route::put('participantes/{participante}', [ParticipanteController::class, 'update'])->name('participantes.update');
        Route::delete('participantes/{participante}', [ParticipanteController::class, 'destroy'])->name('participantes.destroy');

        // Inscripciones (modificación o anulación de matrículas)
        Route::get('inscripciones/{inscripcion}/edit', [InscripcionController::class, 'edit'])->name('inscripciones.edit');
        Route::put('inscripciones/{inscripcion}', [InscripcionController::class, 'update'])->name('inscripciones.update');
        Route::delete('inscripciones/{inscripcion}', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');

        // Reporte Financiero de Ingresos (exclusivo para administración)
        Route::get('reportes/ingresos-por-curso', [ReporteController::class, 'ingresosPorCurso'])->name('reportes.ingresos_por_curso');
    });

    // =========================================================================
    // ACCIONES PERMITIDAS PARA TODOS LOS USUARIOS AUTENTICADOS (User y Admin)
    // El usuario regular puede consultar catálogo, instructores y matricularse
    // =========================================================================

    // Catálogo de Cursos (Consulta)
    Route::get('cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');

    // Horarios y Paralelos Ofertados (Consulta)
    Route::get('paralelos', [ParaleloController::class, 'index'])->name('paralelos.index');
    Route::get('paralelos/{paralelo}', [ParaleloController::class, 'show'])->name('paralelos.show');

    // Cuerpo Docente (Consulta)
    Route::get('instructores', [InstructorController::class, 'index'])->name('instructores.index');
    Route::get('instructores/{instructor}', [InstructorController::class, 'show'])->name('instructores.show');

    // Categorías de Formación (Consulta)
    Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');

    // Participantes (Listado, Ficha y Registro de Alumno)
    Route::get('participantes', [ParticipanteController::class, 'index'])->name('participantes.index');
    Route::get('participantes/create', [ParticipanteController::class, 'create'])->name('participantes.create');
    Route::post('participantes', [ParticipanteController::class, 'store'])->name('participantes.store');
    Route::get('participantes/{participante}', [ParticipanteController::class, 'show'])->name('participantes.show');

    // Matrículas e Inscripciones (Crear inscripción, ver listado y descargar voucher)
    Route::get('inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::get('inscripciones/create', [InscripcionController::class, 'create'])->name('inscripciones.create');
    Route::post('inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::get('inscripciones/{inscripcion}', [InscripcionController::class, 'show'])->name('inscripciones.show');

    // Reportes Académicos Disponibles para Consulta
    Route::get('reportes/inscritos-por-paralelo', [ReporteController::class, 'inscritosPorParalelo'])->name('reportes.inscritos_por_paralelo');
});
