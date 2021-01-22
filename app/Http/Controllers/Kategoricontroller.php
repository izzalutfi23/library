<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class Kategoricontroller extends Controller
{
    public function getkategori(){
        $kat = Kategori::all();
        return response()->json($kat, 200);
    }
}
