<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiProduk;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use App\Notifications\TransaksiNotif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuestController extends Controller
{
    use Notifiable;

    public function index(){
        $produk = Produk::orderBy('id','DESC')->take(4)->get();
        return view('guest.index', compact('produk'));
    }

    public function pesan()
    {
        $produk = Produk::orderBy('id','DESC')->take(4)->get();
        return view('guest.pesan',compact('produk'));
    }

    public function sendEmail(Request $request){
        $data = [
            'title' => $request->tentang,
            'from' => ['address' => $request->email, 'name' => $request->nama],
            'to' => ['address' => getEmailPerusahaan(1),'name' => getNamaPerusahaan()],
            'body' => $request->pesan,
        ];

        Mail::send('mail.sendContact',$data, function($message)use($data) {
            $message->from($data['from']['address'], $data['from']['name'])
            ->to($data['to']['address'], $data['to']['name'])
            ->subject($data['title'])
            ->text($data['body']);
        });

        // Notification::send(User::whereIn('role', ['Admin', 'Staff'])->get(), new TransaksiNotif($data['from']['name']));

        Alert::success('Sukses', 'Email sudah terkirim.');
        return redirect('/');
    }

    public function savePesan(Request $request){
        if (!Auth::check()) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'pesan' => 'required',
            'inputBox' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('guest.pesan')
                ->withErrors($validator)
                ->withInput();
        }else{
            $transaksi = new Transaksi();
            $data = $transaksi->create([
                'invoice' => $this->invoiceKode(),
                'id_user' => Auth()->user()->id ?? 0,
                'nama_customer' => $request->nama,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'deskripsi' => $request->pesan,
                'alamat' => $request->alamat,
                'total' => 0
            ]);

            $detailTransaksi = new DetailTransaksiProduk();
            $inputBox = json_decode($request->inputBox, true);

            foreach ($inputBox as $item) {
                $total = $this->hitungTotalProduk($item['kode_produk'],$item['value']);
                $this->penguranganStok($item['kode_produk'], $item['value']);
                $detailTransaksi->create([
                    'id_transaksi' => $data->id,
                    'kode_produk' => $item['kode_produk'],
                    'jumlah' => $item['value'],
                    'total' => $total
                ]);
                $transaksi->where('id', $data->id)->update(['total' => $total]);
            }
            Alert::success('Sukses', 'Pemesanan sudah terkirim.');
            return redirect(route('histori-transaksi'));
        }
    }

    public function invoiceKode()
    {
        $transaksi = count(Transaksi::all()) + 1;
        $year = Carbon::now()->format('my');
        $invoiceKode = sprintf("%03s", $transaksi) . '-' . sprintf("%02s", rand(1, 100)) . '/INV/' . $year;
        return $invoiceKode;
    }

    public function hitungTotalProduk($kode_produk, $jumlah){
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        return $produk->harga_jual * $jumlah;
    }

    public function penguranganStok($kode_produk, $jumlah){
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        $stok = $produk->stok - $jumlah;
        $produk->update(['stok' => $stok]);
    }
}
