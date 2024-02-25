<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\LaporanBahanBaku;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BahanBakuController extends Controller
{
    // Halaman tampilan tabel
    public function index()
    {
        $bahanBaku = BahanBaku::orderBy('id','desc')->get();
        return view('bahan_baku.index', compact('bahanBaku'));
    }

    // Halaman tampilan add
    public function create()
    {
        return view('bahan_baku.add');
    }

    // Proses simpan
    public function save(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'satuan' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric|not_in:0',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('bahan.create')->withErrors($validator)->withInput();
        }else{
            $bahanBaku = new BahanBaku;
            $slug = $this->checkSlug($request->nama);
            $data = $bahanBaku->create([
                'nama' => $request->nama,
                'slug' => $slug,
                'deskripsi' => $request->deskripsi,
                'satuan' => $request->satuan,
                'stok' => $request->stok,
                'harga' => str_replace('.', '', $request->harga),
            ]);
            $this->addLaporan($data,'Tambah Bahan Baku', $request->stok);
            Alert::success('Sukses', 'Data berhasil tersimpan.');
            return Redirect::route('bahan.index');
        }
    }

    // Halaman tampilan edit
    public function edit($slug){
        $bahanBaku = BahanBaku::where('slug', $slug)->first();
        if ($bahanBaku) {
            return view('bahan_baku.edit', compact('bahanBaku'));
        }
        return abort('404');
    }

    // Proses update
    public function update(Request $request, $slug){
        $bahanBaku = BahanBaku::where('slug',$slug)->first();
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'satuan' => 'required',
            'harga' => 'required|numeric||not_in:0',
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('bahan.edit',$request->slug)->withErrors($validator)->withInput();
        }else{
            $slug = $this->checkSlug($request->nama);
            $bahanBaku->update([
                'nama' => $request->nama,
                'slug' => ($request->slug != $bahanBaku->slug) ? $slug : $request->slug,
                'deskripsi' => $request->deskripsi,
                'satuan' => $request->satuan,
                'harga' => str_replace('.', '', $request->harga),
            ]);
            $this->addLaporan($bahanBaku,'Update Bahan Baku');
            Alert::success('Sukses', 'Data berhasil tersimpan.');
            return Redirect::route('bahan.index');
        }
    }

    // Proses update stok
    public function updateStok(Request $request){
        $bahanBaku = BahanBaku::where('slug',$request->slug)->first();
        $bahanBaku->update([
            'stok' => $bahanBaku->stok + $request->stok,
            'harga' => $bahanBaku->harga
        ]);
        $this->addLaporan($bahanBaku,'Update Stok Bahan Baku', $request->stok);
        Alert::success('Sukses', 'Data berhasil tersimpan.');
        return Redirect::route('bahan.index');
    }

    // Proses delete
    public function delete($slug){
        $bahanBaku = BahanBaku::where('slug', $slug)->first();
        $this->addLaporan($bahanBaku,'Hapus Bahan Baku');

        // Update is_deleted pada laporan
        $laporanBahanBaku = LaporanBahanBaku::where('id_bahan_baku', $bahanBaku->id)->where('keterangan','Tambah Bahan Baku')->first();
        $laporanBahanBaku->update([
            'is_deleted' => true
        ]);

        $bahanBaku->delete();
        Alert::success('Sukses', 'Data berhasil terhapus.');
        return Redirect::route('bahan.index');
    }

    // Ajax get data
    public function getData(Request $request){
        $bahanBaku = BahanBaku::select('nama','slug','stok','harga')->where('slug',$request->slug)->first();
        $bahanBaku['harga'] = currency_IDR($bahanBaku->harga);
        return response()->json($bahanBaku);
    }

    // Cek duplikat slug
    public function checkSlug($data){
        $slug = Str::slug($data);
        $bahanBaku = BahanBaku::where('nama', $data)->get();
        if (count($bahanBaku) >= 1) {
            return $slug.' '.(count($bahanBaku)+1);
        }
        return $slug;
    }

    // Tambah ke laporan
    public function addLaporan($data, $keterangan, $jumlah = null){
        $laporan = new LaporanBahanBaku();
        $laporan->create([
            'id_user' => Auth()->user()->id,
            'id_bahan_baku' => $data->id,
            'jumlah' => $keterangan == 'Tambah Bahan Baku' || $keterangan == 'Update Stok Bahan Baku' ? $jumlah : 0,
            'harga' => $keterangan == 'Tambah Bahan Baku' || $keterangan == 'Update Stok Bahan Baku' ? $data->harga : 0,
            'keterangan' => $keterangan
        ]);
    }
}
