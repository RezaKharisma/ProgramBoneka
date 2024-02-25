<?php

namespace App\Http\Controllers;

use App\Exports\BahanBakuExport;
use App\Exports\PengeluaranBahanBakuExport;
use App\Models\BahanBaku;
use App\Models\LaporanBahanBaku as ModelsLaporanBahanBaku;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanBahanBakuController extends Controller
{
    // Halaman Index
    public function index(){
        $LaporanBahanBakuModel = new ModelsLaporanBahanBaku();
        $BahanBakuModel = new BahanBaku();

        $totalBahanBaku = count($BahanBakuModel->all());
        $laporanBahanBaku = $LaporanBahanBakuModel->with('user')->with('bahan_baku')->orderBy('id', 'desc')->limit(5)->get();
        $laporanPenambahanBulanIni = count($LaporanBahanBakuModel->where('keterangan', 'Tambah Bahan Baku')->orWhere('keterangan', 'Update Stok Bahan Baku')->where('is_deleted',0)->whereMonth('created_at', Carbon::now()->month)->get());
        $pengeluaranBulanIni = $this->pengeluaranBulanIni($LaporanBahanBakuModel->whereIn('keterangan', ['Tambah Bahan Baku', 'Update Stok Bahan Baku'])->where('is_deleted',0)->select('jumlah','harga')->whereMonth('created_at', Carbon::now()->month)->get());

        return view('laporan.bahanBaku', compact('laporanBahanBaku','totalBahanBaku', 'laporanPenambahanBulanIni','pengeluaranBulanIni'));
    }

    public function exportPengeluaran(Request $request){
        $LaporanBahanBakuModel = ModelsLaporanBahanBaku::whereIn('keterangan',['Tambah Bahan Baku', 'Update Stok Bahan Baku'])->where('is_deleted',0);
        $data = $this->pengeluaranBulanIni($LaporanBahanBakuModel, $request->bulan, $request->tahun);
        $date = $request->bulan == "0" ? 'All' : Carbon::parse(date("F", mktime(0, 0, 0, $request->bulan, 10)))->translatedFormat('F');
        if (count($data['data']) > 0) {
            if ($request->exists('exportExcel')) {
                return Excel::download(new PengeluaranBahanBakuExport($data), 'Data Bahan Baku '.$date.' '.$request->tahun.'.xlsx');
            }

            if($request->exists('exportPdf')){
                $pdf = Pdf::loadview('exports.laporanBahanBaku_PDF', ['data' => $data['data'],'total' => $data['total']]);
                return $pdf->download('Data Pengeluaran Bahan Baku '.$date.' '.$request->tahun.'.pdf');
            }
        }
        Alert::error('Error', "Tidak ada data pada bulan $date $request->tahun.");
        return Redirect::route('laporanBahanBaku.index');
    }

    // Export excel
    public function exportExcel(){
        $dateNow = Carbon::now()->format('d-m-Y');
        return Excel::download(new BahanBakuExport, 'Data Bahan Baku '.$dateNow.'.xlsx');
    }

    // Export PDF
    public function exportPdf(){
        $data = BahanBaku::all();
        $dateNow = Carbon::now()->format('d-m-Y');
    	$pdf = Pdf::loadview('exports.bahanBaku_PDF', ['data'=> $data]);
    	return $pdf->download('Data Bahan Baku '.$dateNow.'.pdf');
    }

    // Proses menghitung pengeluaran
    public function pengeluaranBulanIni($data = null, $bulan = null, $tahun = null){
        $result = [
            'data' => $data,
            'total' => 0
        ];
        if ($bulan != "0" && $tahun) {
            $result['data'] = $data->whereMonth('created_at',$bulan)->whereYear('created_at',$tahun)->get();
        }else if ($bulan == "0"){
            $result['data'] = $data->whereYear('created_at',$tahun)->get();
        }
        foreach ($result['data'] as $item) {
            $result['total'] += ($item['jumlah'] * $item['harga']);
        }
        return $result;
    }
}
