<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::post('/get-message', function (){
    return response()->json([
        'message' => 'Hello there, it\'s your first response.'
    ], 200);
});

 
Route::get('/', [UserController::class, 'show']);
Route::post('/send-message', [SmsController::class, 'sendMessage']);
Route::post('/vue-message', [SmsController::class, 'VueMessage']);
Route::post('/vueMedia-message', [SmsController::class, 'VueMediaMessage']);
Route::post('/vueVideo-message', [SmsController::class, 'VueVideoMessage']);
Route::get('/get-message', [MessageController::class, 'getData']);