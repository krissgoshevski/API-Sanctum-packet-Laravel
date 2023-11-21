<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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
Route::post("/register", [AuthController::class, 'register']);
Route::post('/login', [AuthController::class,'login']);



Route::get('/products/search/{name}', [ProductController::class,'search'])->name('products.search');
Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class,'show'])->name('products.show');

// public routes 
//Route::apiResource('/products', ProductController::class);



// protected routes with sanctum packet 
Route::group(['middleware' => ['auth:sanctum']], function () {

Route::post('/products', [ProductController::class,'store'])->name('products.store');
Route::put('/products/{id}', [ProductController::class,'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class,'destroy'])->name('products.delete');

Route::post('/logout', [AuthController::class,'logout'])->name('logout');

});
    
