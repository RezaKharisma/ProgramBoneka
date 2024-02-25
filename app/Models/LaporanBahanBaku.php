<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBahanBaku extends Model
{
    use HasFactory;

    protected $table = "laporan_bahan_baku";

    protected $fillable = ['id_user','id_bahan_baku','is_deleted','keterangan','jumlah','harga'];

    public function user(){
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function bahan_baku(){
        return $this->belongsTo(BahanBaku::class,'id_bahan_baku','id')->withTrashed();
    }

    public function getTableName(){
        return "Laporan Bahan Baku";
    }
}
