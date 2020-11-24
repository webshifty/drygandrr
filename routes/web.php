<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\BotController;

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
Route::post('/bot/getupdates', BotController::getUpdates());
Route::post('bot/sendmessage', function() {
    Telegram::sendMessage([
        'chat_id' => 'RECIPIENT_CHAT_ID',
        'text' => 'Hello world!'
    ]);
    return;
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
