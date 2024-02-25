<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LaporanBahanBakuController;
use App\Http\Controllers\LaporanProdukController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Settings\PageController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Mail\SendInvoice;
use App\Models\DetailTransaksiProduk;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

// restrictRole

Route::get('/', [GuestController::class, 'index'])->name('guest');
Route::post('/', [GuestController::class, 'sendEmail'])->name('guest.sendEmail');
Route::get('/pesan', [GuestController::class, 'pesan'])->name('guest.pesan');
Route::post('/pesan', [GuestController::class, 'savePesan'])->name('guest.savePesan');

Route::get('/login', function () { return redirect(route('login')); });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile-updatephoto', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');

    // Security
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');

    Route::group(['middleware' => ['restrictRole:Customer']], function(){
        Route::get('/histori-transaksi', [CustomerController::class, 'historiTransaksi'])->name('histori-transaksi');
        Route::get('/histori-transaksi/invoice/{invoice}', [CustomerController::class, 'invoice'])->where('invoice', '[\w\s\-_\/]+')->name('histori-transaksi.invoice');
        Route::get('/histori-transaksi/{invoice}/export-pdf', [CustomerController::class, 'exportPdf'])->where('invoice', '[\w\s\-_\/]+')->name('histori-transaksi.exportPdf');
    });

    Route::group(['middleware'=> ['restrictRole:Admin,Staff']],function(){
        // Produk
        Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
        Route::get('/produk/tambah-stok/{kode_produk}', [ProdukController::class, 'createStok'])->name('produk.createStok');
        Route::post('/produk', [ProdukController::class, 'save'])->name('produk.save');
        Route::get('/produk/{kode_produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{kode_produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::put('/produk/{kode_produk}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.updateStok');
        Route::put('/produk/{kode_produk}/update-status', [ProdukController::class, 'updateStatus'])->name('produk.updateStatus');
        Route::delete('/produk/{kode_produk}', [ProdukController::class, 'delete'])->name('produk.delete');
        Route::get('/produk/get_data_bahan_baku', [ProdukController::class, 'getDataBahanBaku']);
        Route::get('/produk/cek_stok_bahan_baku', [ProdukController::class, 'cekStokBahanBaku']);
        Route::get('/produk/get_data_produk', [ProdukController::class, 'getDataProduk']);
        Route::get('/produk/cek_stok_produksi', [ProdukController::class, 'cekStokProduksi']);

        // Bahan Baku
        Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan.index');
        Route::get('/bahan-baku/tambah', [BahanBakuController::class, 'create'])->name('bahan.create');
        Route::get('/bahan-baku/get-data', [BahanBakuController::class, 'getData']);
        Route::get('/bahan-baku/{slug}/edit', [BahanBakuController::class, 'edit'])->name('bahan.edit');
        Route::post('/bahan-baku', [BahanBakuController::class, 'save'])->name('bahan.save');
        Route::put('/bahan-baku/tambah-stok', [BahanBakuController::class, 'updateStok'])->name('bahan.tambahStok');
        Route::put('/bahan-baku/{slug}', [BahanBakuController::class, 'update'])->name('bahan.update');
        Route::delete('/bahan-baku/{slug}', [BahanBakuController::class, 'delete'])->name('bahan.delete');

        // Penjualan
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/tambah', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'save'])->name('transaksi.save');
        Route::get('/transaksi/get-data-produk', [TransaksiController::class, 'getDataProduk']);
        Route::get('/transaksi/cek-stok-produk', [TransaksiController::class, 'cekStokProduk']);
        Route::put('/transaksi/{invoice}/update-status', [TransaksiController::class, 'updateStatus'])->where('invoice', '[\w\s\-_\/]+')->name('transaksi.updateStatus');
        Route::put('/transaksi/{invoice}/batal-transaksi', [TransaksiController::class, 'batalTransaksi'])->where('invoice', '[\w\s\-_\/]+')->name('transaksi.batalTransaksi');
        Route::get('/transaksi/invoice/{invoice}', [TransaksiController::class, 'invoice'])->where('invoice', '[\w\s\-_\/]+')->name('transaksi.invoice');
        Route::get('/transaksi/{invoice}/export-pdf', [TransaksiController::class, 'exportPdf'])->where('invoice', '[\w\s\-_\/]+')->name('transaksi.exportPdf');
    });

    Route::group(['middleware'=> ['restrictRole:Admin']],function(){
        // Tentang
        Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
        Route::put('/tentang/{id}/update', [TentangController::class, 'update'])->name('tentang.update');

        // Page
        Route::get('/page', [PageController::class, 'index'])->name('page.index');
        Route::put('/page', [PageController::class, 'update'])->name('page.update');
        Route::put('/page-updateLogo', [PageController::class, 'updateLogo'])->name('page.updateLogo');
        Route::put('/page-updateFavicon', [PageController::class, 'updateFavicon'])->name('page.updateFavicon');

        // User
        Route::resource('user', UserController::class);
        Route::put('/user/{id}/updateStatus', [UserController::class, 'updateStatus'])->name('user.updateStatus');

        // Laporan Produk
        Route::get('/laporan-produk', [LaporanProdukController::class, 'index'])->name('laporanProduk.index');

        // Export Produk
        Route::get('/laporan-produk/export-excel', [LaporanProdukController::class, 'exportExcel'])->name('produk.exportExcel');
        Route::get('/laporan-produk/export-pdf', [LaporanProdukController::class, 'exportPdf'])->name('produk.exportPdf');
        Route::post('/laporan-produk/export-excel-pengeluaran', [LaporanProdukController::class, 'exportExcelPengeluaran'])->name('produk.exportExcelPengeluaran');
        Route::post('/laporan-produk/export-pdf-pengeluaran', [LaporanProdukController::class, 'exportPdfPengeluaran'])->name('produk.exportPdfPengeluaran');

        // Laporan Bahan Baku
        Route::get('/laporan-bahan-baku', [LaporanBahanBakuController::class, 'index'])->name('laporanBahanBaku.index');

        // Export Bahan Baku
        Route::get('/laporan-bahan-baku/export-excel', [LaporanBahanBakuController::class, 'exportExcel'])->name('bahan.exportExcel');
        Route::get('/laporan-bahan-baku/export-pdf', [LaporanBahanBakuController::class, 'exportPdf'])->name('bahan.exportPdf');
        Route::post('/laporan-bahan-baku/export-pengeluaran', [LaporanBahanBakuController::class, 'exportPengeluaran'])->name('bahan.exportPengeluaran');

        // Laporan Transaksi
        Route::get('/laporan-transaksi', [LaporanTransaksiController::class, 'index'])->name('laporanTransaksi.index');
    });
});

require __DIR__.'/auth.php';
