<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware('auth');


Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('admin/')->group(function () { //Route Gorup Prefix admin
    Route::name('admin.')->group(function () { //Route Group Name admin.
        Route::middleware(['auth'])->group(function () {

                Route::resources([
                    'dashboard' => DashboardController::class,
                ]);

        }); // End middleware auth check login only.
    }); // End Route Name admin.
}); // End Route Gorup Prefix admin

Route::middleware(['auth:sanctum','role:super-admin,admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('users');
    Route::post('/data-user', [UserController::class, 'getUsers'])->name('data_user');
    Route::post('/tambah-user', [UserController::class, 'add'])->name('tambah_user');
    Route::post('/simpan-user', [UserController::class, 'storeUser'])->name('simpan_user');
    Route::post('/edit-user', [UserController::class, 'editUser'])->name('edit_user');
    Route::post('/update-user', [UserController::class, 'updateUser'])->name('update_user');
    Route::delete('/hapus-user', [UserController::class, 'destroyUser'])->name('hapus_user');
});

Route::middleware(['auth:sanctum','role:super-admin,admin'])->group(function () {
    Route::get('/buku', [BookController::class, 'index'])->name('books');
    Route::post('/data-buku', [BookController::class, 'getBooks'])->name('data_buku');
    Route::post('/tambah-buku', [BookController::class, 'add'])->name('tambah_buku');
    Route::post('/simpan-buku', [BookController::class, 'storeBook'])->name('simpan_buku');
    Route::post('/edit-buku', [BookController::class, 'editBook'])->name('edit_buku');
    Route::post('/update-buku', [BookController::class, 'updateBook'])->name('update_buku');
    Route::delete('/hapus-buku', [BookController::class, 'destroyBook'])->name('hapus_buku');
});

Route::middleware('auth:sanctum')->prefix('perpus')->group(function () {
    Route::get('/daftar-buku', [LoanController::class, 'index'])->name('perpus');
    Route::post('/list-buku', [LoanController::class, 'getBooks'])->name('perpus.daftar_buku');
    Route::post('/detail-buku', [LoanController::class, 'detailBook'])->name('perpus.detail_buku');
    Route::post('/pinjam-buku', [LoanController::class, 'borrowBook'])->name('pinjam_buku');
    Route::post('/kembalikan-buku', [LoanController::class, 'returnBook'])->name('kembalikan_buku');
    Route::get('/daftar-peminjaman', [LoanController::class, 'borrow'])->name('perpus.daftar_peminjaman');
    Route::post('/data-peminjaman', [LoanController::class, 'borrowList'])->name('perpus.data_peminjaman');
    Route::post('/detail-peminjaman', [LoanController::class, 'detailBorrow'])->name('perpus.detail_peminjaman');
    Route::get('/overdue', [LoanController::class, 'checkOverdue'])->name('checkOverdue');
    Route::get('/history', [LoanController::class, 'history'])->name('history');
});

Route::get('/posts', function () {
    $response = Http::get('https://jsonplaceholder.typicode.com/posts');
    $posts = collect($response->json())->take(10);
    return view('posts', compact('posts'));
});

Route::delete('/posts/{id}', function ($id) {
    return response()->json(['message' => "Post dengan ID $id telah dihapus"]);
});

Route::get('/modified-posts', function () {
    $response = Http::get('https://jsonplaceholder.typicode.com/posts');
    $posts = collect($response->json())->take(10)->map(function ($post) {
        unset($post['userId']);
        return $post;
    });
    return response()->json($posts);
});