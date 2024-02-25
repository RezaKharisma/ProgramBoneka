<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiProduk;
use App\Models\LaporanProduk;
use App\Models\Produk;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::orderBy('id', 'DESC')->get();
        $detailTransaksi = DetailTransaksiProduk::with('produk')->get();
        $status = [
            'pending' => count(Transaksi::where('status','Pending')->get()),
            'pembayaran' => count(Transaksi::where('status','Pembayaran')->get()),
            'proses' => count(Transaksi::where('status','Proses')->get()),
            'selesai' => count(Transaksi::where('status','Selesai')->get()),
            'batal' => count(Transaksi::where('status','Batal')->get()),
        ];
        return view('transaksi.index', compact('detailTransaksi', 'transaksi', 'status'));
    }

    public function create()
    {
        $invoiceKode = $this->invoiceKode();
        $produk = Produk::where('status', 'Aktif')->get();
        return view('transaksi.create', compact('invoiceKode', 'produk'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_telp' => 'required|numeric',
            'email' => 'required',
            'alamat' => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('transaksi.index')
                ->withErrors($validator)
                ->withInput();
        } else {
            $dataTransaksi = json_decode($request->data, true);
            $data = Transaksi::create([
                'invoice' => $dataTransaksi['invoice'],
                'id_user' => Auth::user()->id,
                'nama_customer' => mb_convert_case($dataTransaksi['nama_customer'], MB_CASE_TITLE, 'UTF-8'),
                'no_telp' => strval(intval(preg_replace('/[^0-9]/', '', $dataTransaksi['no_telp_customer']))),
                'email' => $dataTransaksi['email_customer'],
                'alamat' => $dataTransaksi['alamat_customer'],
                'total' => $dataTransaksi['total'],
            ]);
            $this->saveTabelDetailTransaksi($data->id, $dataTransaksi['transaksi']);
            Alert::success('Sukses', 'Data berhasil tersimpan.');
            return Redirect::route('transaksi.index');
        }
    }

    public function invoice($invoice){
        $transaksi = Transaksi::where('invoice', $invoice)->first();
        $detailTransaksi = DetailTransaksiProduk::with(array('produk' => function($query){$query->withTrashed();}))->where('id_transaksi', $transaksi->id)->get();
        return view('transaksi.invoice', compact('transaksi', 'detailTransaksi'));
    }

    public function saveTabelDetailTransaksi($id, $data)
    {
        foreach ($data as $item) {
            $detailTransaksi = new DetailTransaksiProduk();
            $data = $detailTransaksi->create([
                'id_transaksi' => $id,
                'kode_produk' => $item['produk']['kode_produk'],
                'jumlah' => $item['jumlah'],
                'total' => $item['total'],
            ]);
            $this->penguranganStok($item['produk']['kode_produk'], $item['jumlah']);
            $this->addLaporanProduk($data, 'Produk Terjual');
        }
        return;
    }

    public function penguranganStok($kode_produk, $jumlah)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        $stok = intval($produk->stok) - intval($jumlah);
        $produk->update([
            'stok' => $stok,
        ]);
        return;
    }

    public function invoiceKode()
    {
        $transaksi = count(Transaksi::all()) + 1;
        $year = Carbon::now()->format('my');
        $invoiceKode = sprintf("%03s", $transaksi) . '-' . sprintf("%02s", rand(1, 100)) . '/INV/' . $year;
        return $invoiceKode;
    }

    public function getDataProduk(Request $request)
    {
        $data = [];
        $data['produk'] = Produk::where('kode_produk', $request->kode_produk)->first();
        $data['jumlah'] = $request->jumlah;
        $data['total'] = $request->jumlah * $data['produk']['harga_jual'];
        return response()->json($data);
    }

    public function cekStokProduk(Request $request)
    {
        $produk = Produk::where('kode_produk', $request->kode_produk)->first();
        $cekStok = intval($produk->stok) - intval($request->jumlah);
        $isValid = true;
        if ($cekStok < 0) {
            $isValid = false;
            return response()->json($isValid);
        }
        $isValid = true;
        return response()->json($isValid);
    }

    public function updateStatus($invoice)
    {
        $transaksi = Transaksi::where('invoice', $invoice)->first();
        Alert::success('Sukses', 'Data berhasil tersimpan.');

        if ($transaksi->status == 'Pending') {
            $transaksi->update([
                'status' => 'Pembayaran'
            ]);
            $this->sendInvoice($transaksi);
            return Redirect::route('transaksi.index');
        }

        if ($transaksi->status == 'Pembayaran') {
            $transaksi->update([
                'status' => 'Proses'
            ]);
            return Redirect::route('transaksi.index');
        }

        if ($transaksi->status == 'Proses') {
            $transaksi->update([
                'status' => 'Selesai'
            ]);
            return Redirect::route('transaksi.index');
        }
    }

    public function sendInvoice($transaksi){
        $detailTransaksi = DetailTransaksiProduk::with('produk')->where('id_transaksi', $transaksi->id)->get();
        $forPDF = [
            'transaksi' => $transaksi,
            'detailTransaksi' => $detailTransaksi,
            'logo' => public_path('logo/'.getLogo()),
        ];
        $pdf = Pdf::loadview('exports.transaksiInvoice_PDF', $forPDF);

        $data = [
            'title' => 'Invoice Transaksi',
            'from' => ['address' => getEmailPerusahaan(1), 'name' => getNamaPerusahaan()],
            'to' => ['address' => 'rezakharisma1@gmail.com','name' => $transaksi->nama_customer],
            'name' => 'Syahrizal As',
            'body' => 'Testing Kirim Email di Santri Koding',
        ];

        Mail::send('mail.sendInvoice', $data, function($message)use($data, $pdf, $transaksi) {
            $message->from($data['from']['address'], $data['from']['name'])
                    ->to($data['to']['address'], $data['to']['name'])
                    ->subject($data['title'])
                    ->text($data['body'])
                    ->attachData($pdf->output(), "invoice ".$transaksi->invoice.".pdf");
        });
    }

    public function batalTransaksi($invoice){
        $transaksi = Transaksi::where('invoice', $invoice)->first();
        $detailTransaksi = DetailTransaksiProduk::where('id_transaksi', $transaksi->id)->get();
        foreach ($detailTransaksi as $item) {
            $produk = Produk::all();
            $data = $produk->where('kode_produk', $item->kode_produk)->first();
            $data->update([
                'stok' => $data->stok + $item->jumlah
            ]);
        }
        $transaksi->update([
            'status' => 'Batal'
        ]);
        Alert::success('Sukses', 'Data berhasil tersimpan.');
        return Redirect::route('transaksi.index');
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

    // Tambah ke laporan
    public function addLaporanProduk($data, $keterangan)
    {
        $laporan = new LaporanProduk();
        $laporan->create([
            'id_user' => Auth()->user()->id,
            'kode_produk' => $data->kode_produk,
            'jumlah' => $data->jumlah,
            'harga' => $data->harga,
            'keterangan' => $keterangan,
        ]);
    }
}
