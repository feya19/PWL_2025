<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('kategori.index');
    }

    public function create() {
        return view('kategori.create');
    }
   
    public function store(Request $request) {
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }

    public function edit($id) {
        $data = KategoriModel::findOrFail($id);
        return view('kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->update([
            'kategori_kode' => $request->kodeKategori, 
            'kategori_nama' => $request->namaKategori,
        ]);

        return redirect('/kategori');
    }

    public function destroy($id) {
        KategoriModel::destroy($id);
        
        return redirect('/kategori');
    }
}
