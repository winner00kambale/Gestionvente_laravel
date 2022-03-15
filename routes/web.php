<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\FournisseursController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProdactSaleController;
use App\Http\Controllers\AlertStockController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentsController;

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
//Index Routes
Route::get('/',[UserController::class,'index'])->name('login');
Route::post('/user/authenticate',[UserController::class,'authenticate'])->name('login.authenticate');
Route::get('/dashboard/index',[MasterController::class,'index'])->middleware(['auth'])->name('dashboard.index');
Route::get('/client/index',[ClientsController::class,'index'])->middleware(['auth'])->name('client.index');
Route::get('/fournisseur/index',[FournisseursController::class,'index'])->middleware(['auth'])->name('fournisseur.index');
Route::get('/products/index',[ProductsController::class,'index'])->middleware(['auth'])->name('products.index');
Route::get('/sale/index',[ProdactSaleController::class,'index'])->middleware(['auth'])->name('sale.index');
Route::get('/alert/stock',[AlertStockController::class,'index'])->middleware(['auth'])->name('alert.index');
Route::get('/factures/stock',[PaymentsController::class,'index'])->middleware(['auth'])->name('factures.index');
//Insert Routes
Route::post('/categorie/store',[CategoriesController::class,'store'])->middleware(['auth'])->name('categorie.store');
Route::post('/clients/store',[ClientsController::class,'store'])->middleware(['auth'])->name('clients.store');
Route::post('/fournisseur/store',[FournisseursController::class,'store'])->middleware(['auth'])->name('fournisseur.store');
Route::post('/alert/store',[AlertStockController::class,'store'])->middleware(['auth'])->name('alert.store');
Route::post('/products/store',[ProductsController::class,'store'])->middleware(['auth'])->name('products.store');
Route::post('/productsale/store',[ProdactSaleController::class,'store'])->middleware(['auth'])->name('productsale.store');
Route::post('/facture/store',[ProdactSaleController::class,'store_fac'])->middleware(['auth'])->name('facture.store');
Route::post('/payment/store',[PaymentsController::class,'store'])->middleware(['auth'])->name('payment.index');
//Update Routes
Route::post('/client/update',[ClientsController::class,'update'])->middleware(['auth'])->name('client.update');
Route::post('/fournisseurs/update',[FournisseursController::class,'update'])->middleware(['auth'])->name('fournisseurs.update');

