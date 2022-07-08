<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SlideshowController;
use App\Http\Controllers\ProdukPromoController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------
------
| Web Routes
|--------------------------------------------------------------------
------
|
| Here is where you can register web routes for your application.
These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomepageController::class, 'index']);
Route::get('/about', [HomepageController::class, 'about']);
Route::get('/kontak', [HomepageController::class, 'kontak']);
Route::get('/kategori', [HomepageController::class, 'kategori']);
Route::get('/kategori/{slug}', [HomepageController::class, 'kategoribyslug']);
Route::get('/produk', [HomepageController::class, 'produk']);
// produkdetail
Route::get('produk/{id}', [HomepageController::class, 'produkdetail']);
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    // route kategori
    Route::resource('kategori', KategoriController::class);
    // route produk
    Route::resource('produk', ProdukController::class);
    // route customer
    Route::resource('customer', CustomerController::class);
    // route transaksi
    Route::resource('transaksi', TransaksiController::class);
    // profil
    Route::get('profil', [UserController::class, 'index']);
    // setting profil
    Route::get('setting', [UserController::class, 'setting']);
    // form laporan
    Route::get('laporan', [LaporanController::class, 'index']);
    // proses laporan
    Route::get('proseslaporan', [
        LaporanController::class,
        'proses'
    ]);
    // image
    Route::get('image', [ImageController::class, 'index']);
    // simpan image
    Route::post('image', [ImageController::class, 'store']);
    // hapus image by id
    Route::delete('image/{id}', [ImageController::class, 'destroy']);

    // upload image kategori
    Route::post(
        'imagekategori',
        [KategoriController::class, 'uploadimage']
    );
    // hapus image kategori
    Route::delete(
        'imagekategori/{id}',
        [KategoriController::class, 'deleteimage']
    );
    // upload image produk
    Route::post('produkimage', [ProdukController::class, 'uploadimage']);
    // hapus image produk
    Route::delete('produkimage/{id}', [ProdukController::class, 'deleteimage']);
    // slideshow
    Route::resource('slideshow', SlideshowController::class);
    // produk promo
    Route::resource('promo', ProdukPromoController::class);
    // load async produk
    Route::get('loadprodukasync/{id}', [ProdukController::class, 'loadasync']);
    // wishlist
    Route::resource('wishlist', WishlistController::class);
});
// Route::get('/', function () {
// return view('welcome');
// });
// Route::get('/halo', function () {
// return "Halo nama saya fadlur";
// });
// Route::get('/latihan', [LatihanController::class,'index']);
// Route::get('/blog/{id}', [LatihanController::class,'blog']);
// Route::get('/blog/{idblog}/komentar/{idkomentar}',[LatihanController::class,'komentar']);
// Route::get('/beranda', [LatihanController::class,'beranda']);
Auth::routes();
Route::get('/home', function () {
    return redirect('/admin');
});
