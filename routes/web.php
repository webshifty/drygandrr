<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Api\QuestionsController;
use App\Http\Controllers\Api\RequestsController;
use App\Http\Controllers\Api\UserController;

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
Route::middleware('auth')->get('/dashboard', [BaseController::class, 'dashboard'])->name('requests');
Route::middleware('auth')->get('/q_base', [BaseController::class, 'questionBase'])->name('questions');
Route::middleware('auth')->get('/settings', [BaseController::class, 'settings'])->name('settings');

Route::middleware('auth')->post('/a/update_lead', [BaseController::class, 'updateUserQuestionInfo']);
Route::middleware('auth')->post('/a/add_new_qa', [BaseController::class, 'saveNewQA']);
Route::middleware('auth')->post('/a/update_qa', [BaseController::class, 'updateQABase']);

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::get('questions', [QuestionsController::class, 'questions']);
    Route::post('questions', [QuestionsController::class, 'addQuestion']);
    Route::put('questions/{id}', [QuestionsController::class, 'updateQuestion']);
    Route::delete('questions/{id}', [QuestionsController::class, 'deleteQuestion']);

    Route::get('requests', [RequestsController::class, 'requests']);
    Route::put('requests/{id}', [RequestsController::class, 'updateRequest']);
    Route::put('requests/{id}/responsible', [RequestsController::class, 'assignResponsible']);

    Route::post('user/photo', [UserController::class, 'uploadPhoto']);
    Route::delete('user/photo', [UserController::class, 'deletePhoto']);
});
