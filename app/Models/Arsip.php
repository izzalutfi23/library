<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'digital_library';
    protected $fillable = ['user_id', 'nomor', 'tanggal', 'date', 'judul', 'kategori_id', 'file'];

    function kategori(){
        return $this->belongsTo('App\Models\Kategori', 'kategori_id', 'id');
    }
}
