<?php

use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\CommandeDetailController;
use App\Http\Controllers\Api\EntreeStockController;
use App\Http\Controllers\Api\FournisseurController;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\SortieStockController;
use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategorieController::class);
Route::apiResource('produits', ProduitController::class);
Route::apiResource('clients', ClientController::class);
Route::apiResource('fournisseurs', FournisseurController::class);
Route::apiResource('stocks', StockController::class);
Route::apiResource('entrees-stock', EntreeStockController::class);
Route::apiResource('sorties-stock', SortieStockController::class);
Route::apiResource('commandes', CommandeController::class);
Route::post('commandes/{commande}/send-invoice', [CommandeController::class, 'sendInvoice']);
Route::apiResource('commande-details', CommandeDetailController::class);
