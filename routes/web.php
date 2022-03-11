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
Route::get('/',[UserController::class,'index'])->name('login.index');
Route::post('/user/authenticate',[UserController::class,'authenticate'])->name('login.authenticate');
// Route::get('/',[MasterController::class,'index'])->name('master.index');
Route::get('/dashboard/index',[MasterController::class,'index'])->name('dashboard.index');
Route::get('/client/index',[ClientsController::class,'index'])->name('client.index');
Route::get('/fournisseur/index',[FournisseursController::class,'index'])->name('fournisseur.index');
Route::get('/products/index',[ProductsController::class,'index'])->name('products.index');
Route::get('/sale/index',[ProdactSaleController::class,'index'])->name('sale.index');
Route::get('/alert/stock',[AlertStockController::class,'index'])->name('alert.index');

Route::post('/categorie/store',[CategoriesController::class,'store'])->name('categorie.store');
Route::post('/clients/store',[ClientsController::class,'store'])->name('clients.store');
Route::post('/fournisseur/store',[FournisseursController::class,'store'])->name('fournisseur.store');
Route::post('/alert/store',[AlertStockController::class,'store'])->name('alert.store');
Route::post('/products/store',[ProductsController::class,'store'])->name('products.store');
Route::post('/productsale/store',[ProdactSaleController::class,'store'])->name('productsale.store');

Route::post('/client/update',[ClientsController::class,'update'])->name('client.update');
Route::post('/fournisseurs/update',[FournisseursController::class,'update'])->name('fournisseurs.update');

