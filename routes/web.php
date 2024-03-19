<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VulnerabilityController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('/login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/vulns',[VulnerabilityController::class,'list'])->name('vuln.list');

    Route::get('/vulns/create',[VulnerabilityController::class,"createPage"]);
    Route::post('/vulns/create', [VulnerabilityController::class,'createTicket']);

    Route::get('/vulns/{id}',[VulnerabilityController::class,'details'])->name('vuln.details');

});

require __DIR__.'/auth.php';
