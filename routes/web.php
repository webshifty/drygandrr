<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\BaseController;

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
    return view('welcome');
});
Route::post('/bot/getupdates', BotController::income());

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('admin.dashboard');
//})->name('dashboard');

Route::get('bot', [BotController::class, 'income']);
Route::get('/dashboard', [BaseController::class, 'dashboard']);
Route::post('/a/update_lead', [BaseController::class, 'updateUserQuestionInfo']);
Route::get('/q_base', [BaseController::class, 'questionBase']);
Route::post('/a/add_new_qa', [BaseController::class, 'saveNewQA']);
Route::post('/a/update_qa', [BaseController::class, 'updateQABase']);
