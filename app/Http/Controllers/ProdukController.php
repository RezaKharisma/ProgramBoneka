<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\LaporanBahanBaku;
use App\Models\LaporanProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    // Halaman index
    public function index()
    {
        $produk = Produk::orderBy('id','DESC')->get();
        $detailBahan = [];
        foreach($produk as $key => $item){
            array_push($detailBahan, json_decode($item->bahan_baku, true));
        }
        return view('produk.index', compact('produk'));
    }

    // Halaman tampilan add
    public function create()
    {
        $bahanBaku = BahanBaku::orderBy('id', 'desc')->get();
        $kodeProduk = "BRG" . (count(Produk::withTrashed()->get()) + 1);
        return view('produk.add', compact('bahanBaku', 'kodeProduk'));
    }

    // Halaman tampilan addStok
    public function createStok($kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        $bahanProduk = json_decode($produk->bahan_baku, true);
        $bahanBaku = BahanBaku::all();
        $storeBahanBaku = [];

        foreach ($bahanProduk as $item) {
            $data = $bahanBaku->where('slug', $item['slug'])->first();
            array_push($storeBahanBaku, $data);
        }

        if ($produk) {
            return view('produk.addStok', compact('produk', 'bahanBaku', 'bahanProduk', 'storeBahanBaku'));
        }
        return abort('404');
    }

    // Proses simpan data
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'bahanBaku' => 'required',
            'harga_jual' => 'required|not_in:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('produk.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $produk = new Produk();

            $this->checkInStorage($request->foto);
            $imageName = time().'.'.$request->foto->extension();
            $request->foto->move(public_path('produk_photo'), $imageName);

            $data = $produk->create([
                'kode_produk' => $request->kode_produk,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'bahan_baku' => $request->bahanBaku,
                'harga_beli' => str_replace('.', '', $request->bahanBakuTotal),
                'harga_jual' => str_replace('.', '', $request->harga_jual),
                'foto' => $imageName,
            ]);

            $this->addLaporanProduk($data, 'Tambah Produk');
            Alert::success('Sukses', 'Data berhasil tersimpan.');
            return Redirect::route('produk.index');
        }
    }

    public function edit($kode_produk)
    {
        $bahanBaku = BahanBaku::all();
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        if ($produk) {
            return view('produk.edit', compact('produk', 'bahanBaku'));
        }
        return abort('404');
    }

    public function update(Request $request, $kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'bahanBaku' => 'required',
            'harga_jual' => 'required|not_in:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('produk.edit', $request->kode_produk)
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->foto) {
                $this->checkInStorage($request->foto);
                $imageName = time().'.'.$request->foto->extension();
                $request->foto->move(public_path('produk_photo'), $imageName);
            }

            $produk->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'bahan_baku' => $request->bahanBaku,
                'harga_beli' => str_replace('.', '', $request->bahanBakuTotal),
                'harga_jual' => str_replace('.', '', $request->harga_jual),
                'foto' => $imageName ?? $produk->foto,
            ]);
            $this->addLaporanProduk($produk, 'Update Produk');
            Alert::success('Sukses', 'Data berhasil tersimpan.');
            return Redirect::route('produk.index');
        }
    }

    // Proses simpan data
    public function updateStok(Request $request, $kode_produk)
    {
        $validator = [];
        $validator = Validator::make($request->all(), [
            'stok' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon isi kolom jumlah produksi.');
            $isInvalid = false;
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $produk = Produk::where('kode_produk', $kode_produk)->first();
            $bahanBaku = BahanBaku::all();
            $bahanBakuProduk = json_decode($produk->bahan_baku, true);
            $isInvalid = true;
            foreach ($bahanBakuProduk as $item) {
                $jumlah = intval($item['jumlah']) * intval($request->stok);
                $stokSaatIni = $bahanBaku->where('slug', $item['slug'])->first();
                if ($stokSaatIni->stok < $jumlah) {
                    $isInvalid = false;
                }
            }

            if (!$isInvalid) {
                $validator->getMessageBag()->add('stok','Stok tidak mencukupi dengan jumlah yang ditentukan.');
                Alert::error('Terjadi Kesalahan!', 'Stok anda tidak mencukupi.');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($isInvalid) {
                $produk->update([
                    'stok' => $produk->stok + $request->stok,
                ]);
                $this->penguranganStok($produk->bahan_baku, $request->stok);
                $this->addLaporanProduk($produk, "Penambahan Stok Produk", $request->stok);
                Alert::success('Sukses', 'Data berhasil tersimpan.');
                return Redirect::route('produk.index');
            }
        }
    }

    // Proses update status
    public function updateStatus($id){
        $produk = Produk::where('id', $id)->first();
        $produk->update([
            'status' => $produk->status == 'Aktif' ? 'Tidak Aktif' : 'Aktif'
        ]);
        Alert::success('Sukses', 'Status berhasil tersimpan.');
        return Redirect::route('produk.index');
    }

    // Proses delete
    public function delete($kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        $this->resetStok($produk);
        $this->addLaporanProduk($produk, 'Hapus Produk');
        $produk->delete();
        Alert::success('Sukses', 'Data berhasil terhapus.');
        return Redirect::route('produk.index');
    }

    // Cek File Foto Default
    public function checkInStorage($imgName){
        $path = 'produk_photo/'.$imgName;
        if($imgName == 'default.jpg'){
            return;
        }

        if(file_exists(public_path($path))){
            unlink(public_path($path));
        }

        return;
    }

    // Proses reset stok
    public function resetStok($produk)
    {
        $bahanBaku = BahanBaku::all();
        if ($produk->stok != 0) {
            foreach (json_decode($produk->bahan_baku, true) as $item) {
                $data = $bahanBaku->where('slug', $item['slug'])->first();
                $data->update([
                    'stok' => $data->stok + $item['jumlah'] * $produk->stok,
                ]);
            }
        }
    }

    // Ajax ambil bahan baku
    public function getDataBahanBaku(Request $request)
    {
        $bahanBaku = BahanBaku::where('slug', $request->slug)
            ->select('nama', 'slug', 'harga', 'stok', 'satuan')
            ->first();
        $bahanBaku['harga'] = 'Rp. ' . currency_IDR($bahanBaku->harga);
        return response()->json($bahanBaku);
    }

    // Ajax ambil produk
    public function getDataProduk(Request $request)
    {
        $produk = Produk::where('kode_produk', $request->kode_produk)
            ->select('kode_produk', 'nama', 'deskripsi', 'bahan_baku', 'harga_beli', 'harga_jual', 'stok', 'status')
            ->first();
        $produk['harga_beli'] = 'Rp. ' . currency_IDR($produk->harga_beli);
        $produk['harga_jual'] = 'Rp. ' . currency_IDR($produk->harga_jual);
        $produk['bahan_baku'] = json_decode($produk->bahan_baku, true);
        return response()->json($produk);
    }

    // Ajax cek stok barang
    public function cekStokBahanBaku(Request $request)
    {
        $bahanBaku = BahanBaku::where('slug', $request->slug)->first();
        $cekStok = intval($bahanBaku->stok) - intval($request->jumlah);
        if ($cekStok < 0) {
            $correct = ['isValid' => false];
            return response()->json($correct);
        }
        $totalHarga = $request->jumlah * $bahanBaku->harga;
        $correct = [
            'isValid' => true,
            'total' => $totalHarga,
        ];
        return response()->json($correct);
    }

    public function penguranganStok($barang, $jumlah)
    {
        $bahanModel = new BahanBaku();
        $bahanSelect = json_decode($barang, true);

        foreach ($bahanSelect as $item) {
            $data = $bahanModel->where('slug', $item['slug'])->first();
            $totalJumlah = intval($item['jumlah']) * $jumlah;
            $sisaStok = $data->stok - $totalJumlah;
            $data->update([
                'id' => $data->id,
                'stok' => $sisaStok,
            ]);
            $this->addLaporanBahanBaku($data, $totalJumlah, "Pengurangan Stok Bahan Baku");
        }
    }

    // Tambah ke laporan
    public function addLaporanBahanBaku($data, $totalJumlah, $keterangan)
    {
        $laporan = new LaporanBahanBaku();
        $laporan->create([
            'id_user' => Auth()->user()->id,
            'id_bahan_baku' => $data->id,
            'jumlah' => $keterangan == 'Tambah Bahan Baku' || $keterangan == 'Pengurangan Stok Bahan Baku' ? $totalJumlah : 0,
            'harga' => 0,
            'keterangan' => $keterangan,
        ]);
    }

    // Tambah ke laporan
    public function addLaporanProduk($data, $keterangan, $jumlah = null)
    {
        $laporan = new LaporanProduk();
        $laporan->create([
            'id_user' => Auth()->user()->id,
            'kode_produk' => $data->kode_produk,
            'jumlah' => $keterangan == 'Tambah Stok Produk' || $keterangan == "Penambahan Stok Produk" ? $jumlah : 0,
            'harga' => $keterangan == 'Tambah Stok Produk' || $keterangan == "Penambahan Stok Produk" ? $data->harga : 0,
            'keterangan' => $keterangan,
        ]);
    }
}
