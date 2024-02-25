<?php

namespace App\Http\Controllers;

use App\Exports\PengeluaranBahanBakuExport;
use App\Exports\ProdukExport;
use App\Models\BahanBaku;
use App\Models\LaporanBahanBaku;
use App\Models\LaporanProduk;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanProdukController extends Controller
{
    // Halaman Index
    public function index(){
        $LaporanProdukModel = new LaporanProduk();
        $ProdukModel = new Produk();
        $BahanBakuModel = new BahanBaku();

        $totalProduk = count($ProdukModel->all());
        $laporanProduk = $LaporanProdukModel->with('user')->with(array('produk' => function($query){$query->withTrashed();}))->orderBy('id', 'desc')->limit(5)->get();
        $laporanPembuatanProduk = $LaporanProdukModel->where('keterangan', 'Penambahan Stok Produk')->where('is_deleted',0)->whereMonth('created_at', Carbon::now()->month)->get();
        $laporanPembuatanProduk = $this->produksiBulanIni($laporanPembuatanProduk);

        return view('laporan.produk', compact('totalProduk','laporanProduk','laporanPembuatanProduk'));
    }

    // Export excel
    public function exportExcel(){
        $dateNow = Carbon::now()->format('d-m-Y');
        $data = Produk::all();
        return Excel::download(new ProdukExport, 'Data Produk '.$dateNow.'.xlsx');
    }

    // public function export(Request $request){
    //     $LaporanBahanBakuModel = ModelsLaporanBahanBaku::whereIn('keterangan',['Tambah Produk', 'Penambahan Stok Produk'])->where('is_deleted',0);
    //     $data = $this->pengeluaranBulanIni($LaporanBahanBakuModel, $request->bulan, $request->tahun);
    //     $date = $request->bulan == "0" ? 'All' : Carbon::parse(date("F", mktime(0, 0, 0, $request->bulan, 10)))->translatedFormat('F');
    //     if (count($data['data']) > 0) {
    //         if ($request->exists('exportExcel')) {
    //             return Excel::download(new PengeluaranBahanBakuExport($data), 'Data Bahan Baku '.$date.' '.$request->tahun.'.xlsx');
    //         }

    //         if($request->exists('exportPdf')){
    //             $pdf = Pdf::loadview('exports.laporanBahanBaku_PDF', ['data' => $data['data'],'total' => $data['total']]);
    //             return $pdf->download('Data Pengeluaran Bahan Baku '.$date.' '.$request->tahun.'.pdf');
    //         }
    //     }
    //     Alert::error('Error', "Tidak ada data pada bulan $date $request->tahun.");
    //     return Redirect::route('laporanBahanBaku.index');
    // }

    // Export PDF Pengeluaran
    public function exportExcelPengeluaran(Request $request){
        $LaporanBahanBakuModel = LaporanProduk::where('keterangan', 'Tambah Bahan Baku')->orWhere('keterangan', 'Update Stok Bahan Baku')->where('is_deleted',0);
        $dateNow = Carbon::now()->format('d-m-Y');
        $data = $this->pengeluaranBulanIni($LaporanBahanBakuModel, $request->customRadio);
        return Excel::download(new PengeluaranBahanBakuExport($data), 'Data Bahan Baku '.$dateNow.'.xlsx');
    }

    // Export PDF
    public function exportPdf(){
        $data = Produk::all();
        $dateNow = Carbon::now()->format('d-m-Y');
    	$pdf = Pdf::loadview('exports.produk_PDF', ['data'=> $data]);
    	return $pdf->download('Data Produk '.$dateNow.'.pdf');
    }

    // Export PDF Pengeluaran
    public function exportPdfPengeluaran(Request $request){
        $LaporanBahanBakuModel = LaporanBahanBaku::where('keterangan', 'Tambah Bahan Baku')->orWhere('keterangan', 'Update Stok Bahan Baku')->where('is_deleted',0);
        $dateNow = Carbon::now()->format('d-m-Y');
        $data = $this->pengeluaranBulanIni($LaporanBahanBakuModel, $request->customRadio);
    	$pdf = Pdf::loadview('exports.laporanBahanBaku_PDF', ['data' => $data['data'],'total' => $data['total']]);
    	return $pdf->download('Data Pengeluaran Bahan Baku '.$dateNow.'.pdf');
    }

    public function produksiBulanIni($data){
        $jumlah = 0;
        foreach ($data as $produk) {
            $jumlah += $produk['jumlah'];
        }
        return $jumlah;
    }
}
