<?php

use App\Http\Controllers\PasswdController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome', ['credsOK' => true]);
})->name("welcome");

Route::post('/user/login', [UserController::class, 'login'])->name("users.loginPage");
Route::get('/sold-ip-list', [UserController::class, 'getSoldIpList'])->name("users.soldIpList");
Route::get('/unsold-ip-list', [UserController::class, 'getUnsoldIpList'])->name("users.unsoldIpList");
//Route::get('/user/portal/{filterType}', [PasswdController::class, 'performFilterOnData']);
