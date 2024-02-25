<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiProduk extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_produk';

    protected $fillable = ['id_transaksi','kode_produk','jumlah','total'];

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'id_detail_transaksi_produk','id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class,'kode_produk','kode_produk');
    }
}
