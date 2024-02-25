<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanProduk extends Model
{
    use HasFactory;

    protected $table = "laporan_produk";

    protected $fillable = ['id_user','kode_produk','is_deleted','keterangan','jumlah','harga'];

    public function user(){
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function bahan_baku(){
        return $this->belongsTo(BahanBaku::class,'id_bahan_baku','id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class,'kode_produk','kode_produk');
    }

    public function getTableName(){
        return "Laporan Produk";
    }
}
