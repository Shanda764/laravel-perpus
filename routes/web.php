<?php

use App\Http\Controllers\BukuMasukController;
use App\Http\Controllers\DaftarBukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(DaftarBukuController::class)->group(function () {
    Route::get('/daftar_buku', 'index')->name('daftar_buku');
    Route::get('/daftar_buku/index', 'index')->name('daftar_buku.index');
    Route::get('/daftar_buku/create', 'create')->name('daftar_buku.create');
    Route::post('/daftar_buku/save', 'store')->name('daftar_buku.store');
    Route::put('/daftar_buku/update/{id}', 'update')->name('daftar_buku.update');
    Route::get('/daftar_buku/edit/{id}', 'edit')->name('daftar_buku.edit');
    Route::delete('/daftar_buku/delete/{id}', 'destroy')->name('daftar_buku.destroy');
});
Route::controller(KategoriController::class)->group(function () {
    Route::get('/kategori', 'index')->name('kategori');
    Route::get('/kategori/index', 'index')->name('kategori.index');
    Route::get('/kategori/create', 'create')->name('kategori.create');
    Route::post('/kategori/save', 'store')->name('kategori.store');
    Route::put('/kategori/update/{id}', 'update')->name('kategori.update');
    Route::get('/kategori/edit/{id}', 'edit')->name('kategori.edit');
    Route::delete('/kategori/delete/{id}', 'destroy')->name('kategori.destroy');
});

Route::controller(MemberController::class)->group(function () {
    Route::get('/member', 'index')->name('member');
    Route::get('/member/index', 'index')->name('member.index');
    Route::get('/member/create', 'create')->name('member.create');
    Route::post('/member/save', 'store')->name('member.store');
    Route::put('/member/update/{id}', 'update')->name('member.update');
    Route::get('/member/edit/{id}', 'edit')->name('member.edit');
    Route::get('/member/{id}', [MemberController::class, 'show'])->name('member.show');
    Route::delete('/member/delete/{id}', 'destroy')->name('member.destroy');
    Route::get('/member/cetakMember/{id}', [MemberController::class, 'cetakMember'])->name('member.cetakMember');
});

Route::controller(BukuMasukController::class)->group(function () {
    Route::get('/bukuMasuk', 'index')->name('bukuMasuk');
    Route::get('/bukuMasuk/index', 'index')->name('bukuMasuk.index');
    Route::get('/bukuMasuk/create', 'create')->name('bukuMasuk.create');
    Route::post('/bukuMasuk/save', 'store')->name('bukuMasuk.store');
    Route::put('/bukuMasuk/update/{id}', 'update')->name('bukuMasuk.update');
    Route::get('/bukuMasuk/edit/{id}', 'edit')->name('bukuMasuk.edit');
    Route::delete('/bukuMasuk/delete/{id}', 'destroy')->name('bukuMasuk.destroy');
});

Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
Route::get('/peminjaman/index', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/cek', [PeminjamanController::class, 'cekMember'])->name('peminjaman.cek');
Route::post('/peminjaman/pinjam', [PeminjamanController::class, 'pinjamBuku'])->name('peminjaman.pinjam');
Route::post('/peminjaman/store', [PeminjamanController::class, 'pinjamBuku'])->name('peminjaman.store');

Route::controller(PengembalianController::class)->group(function () {
    Route::get('/pengembalian', 'index')->name('pengembalian');
    Route::get('/pengembalian/index', 'index')->name('pengembalian.index');
    Route::get('/pengembalian/detail/{id}', [PengembalianController::class, 'scan'])->name('pengembalian.detail');
    Route::post('/pengembalian/proses', 'proses')->name('pengembalian.proses');
});

Route::controller(LaporanController::class)->group(function () {
    Route::get('/laporan', 'index')->name('laporan.index');
    Route::get('/laporan/cari', 'cariLaporan')->name('laporan.cari_laporan');
    Route::get('/laporan/invoice', 'cetakPdf')->name('laporan.invoice');
});
