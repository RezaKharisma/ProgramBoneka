<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "bahan_baku";

    protected $fillable = ['nama','slug','deskripsi','satuan','stok','harga'];

    protected $dates = ['deleted_at'];
}
