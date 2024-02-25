<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanTransaksiController extends Controller
{
    public function index(){
        $transaksi = new Transaksi();
        $dataTransaksi = $transaksi->with('user')->orderBy('id','desc')->get();
        $transaksiBulanIni = count($transaksi->whereMonth('created_at', Carbon::now()->month)->get());
        $transaksiTotalBulanIni = $this->totalCount($transaksi->whereMonth('created_at', Carbon::now()->month)->get());
        return view('laporan.transaksi', compact('dataTransaksi','transaksiBulanIni', 'transaksiTotalBulanIni'));
    }

    public function totalCount($transaksi){
        $total = 0;
        foreach ($transaksi as $item) {
            $total += $item['total'];
        }
        return $total;
    }
}
