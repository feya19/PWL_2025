<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Models\LevelModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('level.index');
    }

    public function create() {
        return view('Level.create');
    }
   
    public function store(Request $request) {
        LevelModel::create([
            'level_kode' => $request->kodeLevel,
            'level_nama' => $request->namaLevel,
        ]);
        return redirect('/level');
    }

    public function edit($id) {
        $data = LevelModel::findOrFail($id);
        return view('Level.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $Level = LevelModel::findOrFail($id);
        $Level->update([
            'level_kode' => $request->kodeLevel, 
            'level_nama' => $request->namaLevel,
        ]);

        return redirect('/level');
    }

    public function destroy($id) {
        LevelModel::destroy($id);
        
        return redirect('/level');
    }
}
