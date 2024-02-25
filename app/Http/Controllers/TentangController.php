<?php

namespace App\Http\Controllers;

use App\Models\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TentangController extends Controller
{
    public function index(){
        $tentang = Tentang::first();
        return view('settings.tentang.index', compact('tentang'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'no_tlp1' => 'required|numeric',
            'no_tlp2' => 'nullable|numeric',
            'email1' => 'required|email:dns',
            'email2' => 'nullable|email:dns',
            'instagram' => 'nullable',
            'facebook' => 'nullable',
            'x'=> 'nullable'
        ]);

        if ($validator->fails()) {
            Alert::error('Terjadi Kesalahan!', 'Mohon periksa form kembali.');
            return Redirect::route('tentang.index')
                ->withErrors($validator)
                ->withInput();
        }else{
            $tentang = Tentang::where('id', $id)->first();
            $tentang->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'no_tlp1' => $request->no_tlp1,
                'no_tlp2' => $request->no_tlp2,
                'email1' => strtolower($request->email1),
                'email2' => strtolower($request->email2),
                'instagram' => $request->instagram,
                'facebook' => $request->facebook,
                'x'=> $request->x
            ]);
            Alert::success('Sukses', 'Data berhasil tersimpan.');
            return Redirect::route('tentang.index');
        }
    }
}
