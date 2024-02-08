<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAutenticated;
use App\Http\Middleware\SetSanctumGuard;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/create',[AdminController::class,'store']);
Route::post('/login',[AdminController::class,'login']);
Route::get('admin/teste',[AdminController::class,'verificaUsuarioLogado'])->middleware([
    'auth:sanctum',
    SetSanctumGuard::class,
    IsAutenticated::class
]);
