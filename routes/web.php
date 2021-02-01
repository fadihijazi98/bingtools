<?php

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

//exec("ping -c 1 -w 3 " . $ip_address . " | head -n 2 | tail -n 1 | awk '{print $7}'", $ping_time);

Route::get('/', function () {
    return redirect("/login");
});

Auth::routes();

Route::middleware("auth")->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/dns/loockup', [\App\Http\Controllers\LoockupController::class, 'index']);

    Route::get('/subnet', [\App\Http\Controllers\IpsTrackerController::class, 'index']);

    Route::post('/subnet', [\App\Http\Controllers\IpsTrackerController::class, 'search']);

    Route::post('/subnet/updatecomment', [\App\Http\Controllers\IpsTrackerController::class, 'updateComment']);

    Route::get('/subnet/{ip}/{from}/{limit?}', [\App\Http\Controllers\IpsTrackerController::class, 'fetchIps']);

    Route::get('/check_ip/{ip}/{subnet_ip_address}', [\App\Http\Controllers\IpsTrackerController::class, 'checkIp']);



});
