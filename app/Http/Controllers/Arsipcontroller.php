<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip;

class Arsipcontroller extends Controller
{
    public function getarsip(){
        $arsip = Arsip::with(['kategori'=>function($q){
            $q->select('id', 'kategori');
        }])->get();

        foreach($arsip as $data){
            $data->file = json_decode($data->file);
        }
        return response()->json($arsip, 200);
    }

    public function store(Request $request){
        $request->file('file')->move('file/', $request->file('file')->getClientOriginalName());
        $nama_file = $request->file('file')->getClientOriginalName();
        $url = url("file/{$nama_file}");

        $file = [
            'nama_file' => $nama_file,
            'url_file' => $url
        ];
        $jsonfile = json_encode($file);

        Arsip::create([
            'user_id' => Auth()->user()->id,
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'file' => $jsonfile
        ]);

        return response()->json([
            'status' => 'Berhasil',
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    public function update(Request $request){
        if($request->hasFile('file')){
            $request->file('file')->move('file/', $request->file('file')->getClientOriginalName());
            $nama_file = $request->file('file')->getClientOriginalName();
            $url = url("file/{$nama_file}");

            $file = [
                'nama_file' => $nama_file,
                'url_file' => $url
            ];
            $jsonfile = json_encode($file);

            $arsip = Arsip::whereId($request->id)->update([
                'user_id' => Auth()->user()->id,
                'nomor' => $request->nomor,
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'kategori_id' => $request->kategori_id,
                'file' => $jsonfile
            ]);
            
            if($arsip){
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diubah'
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal diubah!'
                ], 201);
            }
        }
        else{
            $arsip = Arsip::whereId($request->id)->update([
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
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal diubah!'
                ], 201);
            }
        }
    }

    public function destroy(Request $request){
        $arsip = Arsip::destroy('id', $request->id);
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
