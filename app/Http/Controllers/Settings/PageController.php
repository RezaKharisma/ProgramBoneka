<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(){
        $page = Page::first();
        return view('settings.pages.index', compact('page'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:50',
            'deskripsi' => 'required|max:255'
        ]);

        if($validator->fails()){
            return Redirect::route('page.index')->with('danger', 'Periksa form kembali!')->withErrors($validator)->withInput();
        }else{
            $page = Page::first();
            $page->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ]);
            return Redirect::route('page.index')->with('success', 'Data berhasil terupdate!');
        }
    }

    public function updateLogo(Request $request){
        $validator = Validator::make($request->all(), ['logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',]);

        if($validator->fails()){
            return Redirect::route('page.index')->with('danger', 'Periksa form kembali!')->withErrors($validator)->withInput();
        }else{
            $page = Page::first();
            $this->checkInStorage($page->logo);
            $imageName = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('logo'), $imageName);

            $page->update([
                'logo' => $imageName
            ]);
            return Redirect::route('page.index')->with('success', 'Logo berhasil terupdate!');
        }
    }

    public function updateFavicon(Request $request){
        $validator = Validator::make($request->all(), ['favicon' => 'required|image|mimes:jpeg,png,jpg|max:2048',]);

        if ($validator->fails()) {
            return Redirect::route('page.index')->with('danger', 'Periksa form kembali!')->withErrors($validator)->withInput();
        }else{
            $page = Page::first();
            $this->checkInStorage($page->favicon);
            $imageName = time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('logo'), $imageName);
            $page->update([
                'favicon' => $imageName
            ]);
            return Redirect::route('page.index')->with('success', 'Favicon berhasil terupdate!');
        }

    }

    public function checkInStorage($imgName){
        $path = 'logo/'.$imgName;
        if(file_exists(public_path($path)) && $imgName != 'logo-default.png'){
            unlink(public_path($path));
        }
    }
}
