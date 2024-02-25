<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\DetailTransaksiProduk;
use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bahanBaku = new BahanBaku();
        $produk = new Produk();
        $transaksi = new Transaksi();

        $countBahan = count($bahanBaku->get());
        $countProduk = count($produk->get());
        $transaksiHariIni = count($transaksi->whereDate('created_at', Carbon::now())->get());

        $topProduk = DetailTransaksiProduk::selectRaw("kode_produk,count(id) as top")
            ->with('produk')
            ->groupBy('kode_produk')
            ->orderBy('top', 'DESC')
            ->limit('5')
            ->get();

        $transaksiPending = $transaksi->where('status', 'Pending')
            ->paginate(3);

        return view('dashboard', compact('countBahan', 'countProduk', 'transaksiHariIni', 'topProduk', 'transaksiPending'));
    }
}
