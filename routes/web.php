<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuratKeluarController;
use Mockery\Generator\Parameter;

// Route::get('/', function () {
    // return view('dashboard');
// })->name('dashboard');


//route sederhana

//Route::get('/surat-masuk', function (){
//     return 'Halaman Surat Masuk';
// });

//route dengan parameter
// Route::get('/surat-masuk/{id}', function ($id){
//     return 'Detail Surat Masuk dengan ID:' .$id;
// });

//named route
// Route::get('/surat-masuk', function (){
//     return 'Halaman Surat Masuk';
// })->name('surat-masuk.index');


//php artisan route:list

//route : pintu pertama yang dibaca laravel

//php artisan make:controller SuratMasukController "SuratMasukController" <- Nama file



// Route::get('/surat-masuk',      [SuratMasukController::class, 'index'])->name('surat-masuk.index');
// Route::get('/surat-masuk/{id}', [SuratMasukController::class, 'show'])->name('surat-masuk.show');


//surat masuk
// Route::resource('surat-masuk', SuratMasukController::class)
    // ->parameters(['surat-masuk' => 'id']);

//surat keluar
Route::resource('surat-keluar', SuratKeluarController::class)
     ->parameters(['surat-keluar' => 'id']);

Route::middleware('guest')->group(function (){
    Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
    Route::post('/login',[LoginController::class, 'login'])
        ->name('login.submit');
});

Route::middleware('auth')->group(function () {

    Route::get('/', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('surat-masuk', SuratMasukController::class)
        ->except(['index', 'show'])
        ->parameters(['surat-masuk' => 'id'])
        ->middleware('can:manage-letters');

    Route::resource('surat-masuk', SuratMasukController::class)
        ->only(['index','show'])
        ->parameters(['surat-masuk' => 'id']);

    Route::resource('surat-keluar', SuratKeluarController::class)
        ->only(['index','show'])
        ->parameters(['surat-keluar' => 'id'])
        ->middleware('can:manage-letters');

    Route::resource('surat-keluar', SuratKeluarController::class)
        ->except(['index','show'])
        ->parameters(['surat-keluar' => 'id'])
        ->middleware('can:manage-letters');
});
