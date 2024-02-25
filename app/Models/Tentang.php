<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
    use HasFactory;

    public $table = 'tentang';

    public $fillable = ['nama','alamat','deskripsi','no_tlp1','no_tlp2','email1','email2','instagram','facebook','x'];
}
