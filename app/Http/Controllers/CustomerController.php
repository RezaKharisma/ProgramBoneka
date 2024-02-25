<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiProduk;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function historiTransaksi(){
        $transaksiTerbaru = Transaksi::with('user')->where('id_user', Auth()->user()->id)->where('status','Pending')->get();
        $transaksiSelesai = Transaksi::with('user')->where('id_user', Auth()->user()->id)->whereIn('status', ['Selesai','Batal'])->get();
        $detailTransaksi = DetailTransaksiProduk::with('produk')->whereIn('id_transaksi', $this->idTransaksi(Transaksi::with('user')->where('id_user', Auth()->user()->id)->get()))->get();

        return view('customer.historiTransaksi', compact('transaksiTerbaru', 'transaksiSelesai', 'detailTransaksi'));
    }

    public function idTransaksi($transaksi){
        $id = [];
        foreach ($transaksi as $item) {
            array_push($id, $item->id);
        }
        return $id;
    }

    public function invoice($invoice){
        $transaksi = Transaksi::where('invoice', $invoice)->first();
        $detailTransaksi = DetailTransaksiProduk::with(array('produk' => function($query){$query->withTrashed();}))->where('id_transaksi', $transaksi->id)->get();
        return view('customer.invoice', compact('transaksi', 'detailTransaksi'));
    }

    // Export PDF
    public function exportPdf($invoice){
        $transaksi = Transaksi::where('invoice', $invoice)->first();
        $detailTransaksi = DetailTransaksiProduk::with('produk')->where('id_transaksi', $transaksi->id)->get();
        $dateNow = Carbon::now()->format('d-m-Y');
    	$pdf = Pdf::loadview('exports.transaksiInvoice_PDF', [
            'transaksi' => $transaksi,
            'detailTransaksi' => $detailTransaksi,
            'logo' => public_path('logo/'.getLogo())
        ]);
    	return $pdf->download('Data Transaksi ('.$transaksi->invoice.') '.$dateNow.'.pdf');
    }
}
