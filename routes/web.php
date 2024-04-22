<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SynchronizeController;
use App\Models\Tes;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


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

Route::get('/create-admin', function () {
    User::create([
        'name' => "Administrator",
        'email' => "administrator@mail.com",
        'username' => "admin",
        'password' => Hash::make("password1"),
        'role' => "admin",
    ]);
});

Route::get('/login', function () {
    return view('pages.login');
})->name('login');


Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/synchronize', [SynchronizeController::class, 'index'])->name('synchronize')->middleware('auth');
Route::get('/synchronize-add', [SynchronizeController::class, 'add'])->name('synchronize-add')->middleware('auth');
Route::post('/synchronize-save', [SynchronizeController::class, 'save'])->name('synchronize-save')->middleware('auth');
Route::get('/synchronize-edit/{id}', [SynchronizeController::class, 'edit'])->name('synchronize-edit')->middleware('auth');
Route::post('/synchronize-update/{id}', [SynchronizeController::class, 'update'])->name('synchronize-update')->middleware('auth');
Route::post('/synchronize-query', [SynchronizeController::class, 'query'])->name('synchronize-query')->middleware('auth');
Route::post('/synchronize-delete', [SynchronizeController::class, 'delete'])->name('synchronize-delete')->middleware('auth');
Route::post('/synchronize-run/{id_synchronize}', [SynchronizeController::class, 'runSynchronize'])->name('synchronize-run')->middleware('auth');

Route::get('/', function () {
    return view('pages.login');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/history', function () {
    return view('pages.history');
})->name('history');
Route::get('/queue', function () {
    return view('pages.queue');
})->name('queue');
Route::get('/failed', function () {
    return view('pages.failed_jobs');
})->name('failed');
Route::get('/change-password', function () {
    return view('pages.change-password');
})->name('change-password');


Route::get('/chunk', function () {

    // DB::connection('pgsql_self')->orderBy('nama')->take(10)->chunk(10, function (Collection $items) {
    //     foreach ($items as $index => $item) {

    //         echo $item;
    //     }
    // });


    // $batchSize = 100;

    // // Hitung jumlah halaman yang diperlukan berdasarkan jumlah total data dan ukuran batch
    // $totalData = 100000;
    // $totalPages = ceil($totalData / $batchSize);
    // $coll = [];
    // // Looping untuk mendapatkan setiap halaman data
    // for ($page = 1; $page <= $totalPages; $page++) {
    //     $offset = ($page - 1) * $batchSize;

    //     // Mengambil data dari tabel 'tes' dengan menggunakan query raw
    //     $data = DB::connection('pgsql_self')
    //         ->select("SELECT  TOP $batchSize * FROM tes OFFSET $offset");
    //     array_push($coll, $data);
    // }
    // return $coll;
});
