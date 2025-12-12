<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () { return view('Index'); });

Route::view('/About', 'About');
Route::view('/Contact', 'Contact');

Route::get('/Login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/Login', [AuthController::class, 'login'])->name('login.post');

Route::get('/Register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/Register', [AuthController::class, 'register'])->name('register.post');

Route::get('/Pilih', function () { return view('Pilih'); })->middleware('auth');

Route::get('/Penjual', [PenjualController::class, 'index'])->name('penjual.index');

Route::get('/Penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::post('/Penjualan/Store', [PenjualanController::class, 'store'])->name('penjualan.store');
Route::get('/Penjualan/{id}/Edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
Route::put('/Penjualan/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
Route::delete('/Penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
Route::get('/Penjualan/Report', [PenjualanController::class, 'generatePDF'])->name('penjualan.report');

Route::get('/Pembeli', function () { return view('Pembeli'); });

Route::get('/Belanja', [KeranjangController::class, 'index'])->name('belanja');


Route::get('/transaksi', [TransaksiController::class,'index'])->name('transaksi.index');
Route::get('/transaksi/list', [TransaksiController::class,'list']);
Route::post('/transaksi', [TransaksiController::class,'store']);
Route::get('/transaksi/{id}', [TransaksiController::class,'show']);
Route::put('/transaksi/{id}', [TransaksiController::class,'update']); // ubah ke PUT
Route::delete('/transaksi/{id}', [TransaksiController::class,'destroy']);
Route::get('/transaksi/pdf/download', [TransaksiController::class,'pdf'])->name('transaksi.pdf.download');

Route::get('/Keranjang/Add/{id}', [KeranjangController::class, 'add'])->name('keranjang.add');
Route::get('/Keranjang/BuyNow/{id}', [KeranjangController::class, 'buyNow'])->name('keranjang.buynow');
Route::get('/Keranjang/View', [KeranjangController::class, 'view'])->name('keranjang.view');
Route::get('/Keranjang/Remove/{key}', [KeranjangController::class, 'remove'])->name('keranjang.remove');

Route::get('/Pembayaran', [KeranjangController::class, 'checkout'])->name('checkout');
Route::post('/Pembayaran/Proses', [KeranjangController::class, 'processPayment'])->name('checkout.process');

Route::get('/Rating/{id}', [KeranjangController::class, 'showRating'])->name('rating.show');
Route::post('/Rating/Proses', [KeranjangController::class, 'processRating'])->name('rating.process');
