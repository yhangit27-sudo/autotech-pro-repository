<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ServicesCatalogController;
use App\Http\Controllers\FipeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'doLogout'])->name('logout');

Route::middleware(['auth.custom'])->group(function () {

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    
    
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios/criar', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/usuarios/{id}/editar', [UserController::class, 'update'])->name('users.update');
    Route::post('/usuarios/{id}/deletar', [UserController::class, 'destroy'])->name('users.destroy');

    
    
    
    Route::get('/veiculos', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/veiculos/criar', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/veiculos/criar', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/veiculos/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/veiculos/{id}/editar', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::post('/veiculos/{id}/editar', [VehicleController::class, 'update'])->name('vehicles.update');

    
    
    
    Route::get('/ordens', [ServiceOrderController::class, 'index'])->name('orders.index');
    Route::get('/ordens/criar', [ServiceOrderController::class, 'create'])->name('orders.create');
    Route::post('/ordens/criar', [ServiceOrderController::class, 'store'])->name('orders.store');
    Route::get('/ordens/{id}', [ServiceOrderController::class, 'show'])->name('orders.show');
    Route::get('/ordens/{id}/editar', [ServiceOrderController::class, 'edit'])->name('orders.edit');
    Route::post('/ordens/{id}/editar', [ServiceOrderController::class, 'update'])->name('orders.update');
    Route::post('/ordens/{id}/status', [ServiceOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/ordens/{id}/fotos', [ServiceOrderController::class, 'uploadPhotos'])->name('orders.photos');

    
    
    
    Route::get('/pecas', [PartController::class, 'index'])->name('parts.index');
    Route::get('/pecas/criar', [PartController::class, 'create'])->name('parts.create');
    Route::post('/pecas/criar', [PartController::class, 'store'])->name('parts.store');
    Route::get('/pecas/{id}/editar', [PartController::class, 'edit'])->name('parts.edit');
    Route::post('/pecas/{id}/editar', [PartController::class, 'update'])->name('parts.update');
    Route::post('/pecas/{id}/deletar', [PartController::class, 'destroy'])->name('parts.destroy');

    
    
    
    Route::get('/servicos', [ServicesCatalogController::class, 'index'])->name('services.index');
    Route::get('/servicos/criar', [ServicesCatalogController::class, 'create'])->name('services.create');
    Route::post('/servicos/criar', [ServicesCatalogController::class, 'store'])->name('services.store');
    Route::get('/servicos/{id}/editar', [ServicesCatalogController::class, 'edit'])->name('services.edit');
    Route::post('/servicos/{id}/editar', [ServicesCatalogController::class, 'update'])->name('services.update');
    Route::post('/servicos/{id}/deletar', [ServicesCatalogController::class, 'destroy'])->name('services.destroy');

    
    
    
    Route::get('/fipe', [FipeController::class, 'index'])->name('fipe.index');
    
    Route::get('/fipe/marcas', [FipeController::class, 'getMarcas'])->name('fipe.marcas');
    
    Route::get('/fipe/modelos/{marcaId}', [FipeController::class, 'getModelos'])->name('fipe.modelos');
    
    Route::get('/fipe/anos/{marcaId}/{modeloId}', [FipeController::class, 'getAnos'])->name('fipe.anos');
    
    Route::get('/fipe/valor/{marcaId}/{modeloId}/{ano}', [FipeController::class, 'getValor'])->name('fipe.valor');

});
