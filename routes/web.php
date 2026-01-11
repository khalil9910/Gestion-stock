<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\FournisseurController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Stock\EntreeStockController;
use App\Http\Controllers\Stock\SortieStockController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Ventes\CommandeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('categories/archive', [CategorieController::class, 'archive'])->name('categories.archive');
    Route::post('categories/{id}/restore', [CategorieController::class, 'restore'])->name('categories.restore');

    Route::get('produits/archive', [ProduitController::class, 'archive'])->name('produits.archive');
    Route::post('produits/{id}/restore', [ProduitController::class, 'restore'])->name('produits.restore');

    Route::get('clients/archive', [ClientController::class, 'archive'])->name('clients.archive');
    Route::post('clients/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');

    Route::get('fournisseurs/archive', [FournisseurController::class, 'archive'])->name('fournisseurs.archive');
    Route::post('fournisseurs/{id}/restore', [FournisseurController::class, 'restore'])->name('fournisseurs.restore');

    Route::resource('categories', CategorieController::class);
    Route::resource('produits', ProduitController::class);
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('clients', ClientController::class);
});

Route::middleware(['auth', 'role:admin,employe'])->prefix('stock')->name('stock.')->group(function () {
    Route::get('/', [StockController::class, 'index'])->name('index');

    Route::get('/entrees', [EntreeStockController::class, 'index'])->name('entrees.index');
    Route::get('/entrees/create', [EntreeStockController::class, 'create'])->name('entrees.create');
    Route::post('/entrees', [EntreeStockController::class, 'store'])->name('entrees.store');

    Route::get('/sorties', [SortieStockController::class, 'index'])->name('sorties.index');
    Route::get('/sorties/create', [SortieStockController::class, 'create'])->name('sorties.create');
    Route::post('/sorties', [SortieStockController::class, 'store'])->name('sorties.store');
});

Route::middleware(['auth', 'role:admin,employe'])->prefix('exports')->name('exports.')->group(function () {
    Route::get('/stock', [ExportController::class, 'stock'])->name('stock');
    Route::get('/commandes', [ExportController::class, 'commandes'])->name('commandes');
    Route::get('/commande-details', [ExportController::class, 'commandeDetails'])->name('commande_details');
});

Route::middleware(['auth', 'role:admin,employe'])->prefix('ventes')->name('ventes.')->group(function () {
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/create', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
    Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::get('/commandes/{commande}/facture', [CommandeController::class, 'facture'])->name('commandes.facture');
    Route::get('/commandes/{commande}/facture/pdf', [CommandeController::class, 'facturePdf'])->name('commandes.facture.pdf');
});

require __DIR__.'/auth.php';
