<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "produk";

    protected $fillable = ['kode_produk','nama','deskripsi','bahan_baku','harga_beli','harga_jual','stok','foto','status'];

    protected $dates = ['deleted_at'];

    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksiProduk::class, 'kode_produksi', 'kode_produksi');
    }
}
