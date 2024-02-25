<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = ['invoice','id_user','nama_customer','no_telp','email','alamat','deskripsi','jumlah','total','status'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user','id');
    }

    // public function detailTransaksi(){
    //     return $this->hasMany(DetailTransaksiProduk::class, 'id_transaksi_produk','id_transaksi_produk');
    // }
}
