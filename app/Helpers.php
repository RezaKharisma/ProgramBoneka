<?php

use App\Models\Page;
use App\Models\Tentang;
use App\Models\User;
use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Support\Facades\Blade;

if (! function_exists('getUsers')) {
    function getUsers($id = null){
        $users = $id ? User::where('id',$id)->first() : Auth()->user()->name;
        return $users;
    };
}

if (! function_exists('getJudul')) {
    function getJudul()
    {
        $page = Page::first();
        return $page->judul;
    }
}

if (! function_exists('getDeskripsi')) {
    function getDeskripsi()
    {
        $page = Page::first();
        return $page->deskripsi;
    }
}

if (! function_exists('getLogo')) {
    function getLogo()
    {
        $page = Page::first();
        return $page->logo;
    }
}

if (! function_exists('getFavicon')) {
    function getFavicon()
    {
        $page = Page::first();
        return $page->favicon;
    }
}

if (! function_exists('currency')) {
    function currency_IDR($float){
        return number_format($float,0,',','.');
    };
}

if (! function_exists('stokCheck')) {
    function stokCheck($stok){
        if ($stok <= 5) {
            return "<span class='mr-1 dot dot-lg bg-danger'></span>".$stok;
        }return $stok;
    };
}

if (! function_exists('getNamaPerusahaan')) {
    function getNamaPerusahaan(){
        $tentang = Tentang::first();
        return $tentang->nama;
    };
}

if (! function_exists('getDeskripsiPerusahaan')) {
    function getDeskripsiPerusahaan(){
        $tentang = Tentang::first();
        return $tentang->deskripsi;
    };
}

if (! function_exists('getAlamatPerusahaan')) {
    function getAlamatPerusahaan(){
        $tentang = Tentang::first();
        return $tentang->alamat;
    };
}

if (! function_exists('getEmailPerusahaan')) {
    function getEmailPerusahaan($no){
        $data = "";
        $data = Tentang::first();
        switch ($no) {
            case 1:
            return $data->email1;
            break;

            case 2:
            return $data->email2;
            break;
        }
    };
}

if (! function_exists('getNoTelp')) {
    function getNoTelp(Int $no){
        $data = "";
        $data = Tentang::first();
        switch ($no) {
            case 1:
            return $data->no_tlp1;
            break;

            case 2:
            return $data->no_tlp2;
            break;
        }
    };
}

if (! function_exists('getSocMedPerusahaan')) {
    function getSocMedPerusahaan(String $socmed){
        $data = Tentang::select('instagram','facebook','x')->first();
        switch ($socmed) {
            case 'instagram':
                return htmlSocMed($data->instagram, 'instagram');
                break;

            case 'facebook':
                return htmlSocMed($data->facebook, 'facebook');
                break;

            case 'x':
                return htmlSocMed($data->x, 'twitter');
                break;
        }
    };

    function htmlSocMed($link, $class)
    {
        return "<a href='$link' class='$class'><i class='bx bxl-$class'></i></a>";
    }
}


