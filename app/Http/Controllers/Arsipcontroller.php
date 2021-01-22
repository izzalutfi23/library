<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip;

class Arsipcontroller extends Controller
{
    public function getarsip(){
        $arsip = Arsip::all();
        return response()->json($arsip, 200);
    }

    public function store(Request $request){
        $request->file('file')->move('file/', $request->file('file')->getClientOriginalName());
        $nama_file = $request->file('file')->getClientOriginalName();

        Arsip::create([
            'user_id' => Auth()->user()->id,
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'file' => url("file/{$nama_file}")
        ]);

        return response()->json([
            'status' => 'Berhasil',
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id){
        if($request->hasFile('file')){
            $request->file('file')->move('file/', $request->file('file')->getClientOriginalName());
            $nama_file = $request->file('file')->getClientOriginalName();

            $arsip = Arsip::whereId($id)->update([
                'user_id' => Auth()->user()->id,
                'nomor' => $request->nomor,
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'kategori_id' => $request->kategori_id,
                'file' => url("file/{$nama_file}")
            ]);
            
            if($arsip){
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diubah'
                ], 201);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal diubah!'
                ], 201);
            }
        }
        else{
            $arsip = Arsip::whereId($id)->update([
                'user_id' => Auth()->user()->id,
                'nomor' => $request->nomor,
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'kategori_id' => $request->kategori_id
            ]);
            
            if($arsip){
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diubah'
                ], 201);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal diubah!'
                ], 201);
            }
        }
    }

    public function destroy($id){
        $arsip = Arsip::destroy('id', $id);
        if($arsip){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus'
            ], 201);
        }
    }
}
