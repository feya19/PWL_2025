<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();

        // $user = UserModel::findOr(20, ['username', 'nama'], function () {
        //     abort(404);
        // });

        // $user = UserModel::where('username', 'manager9')->firstOrFail();

        // return view('user', ['data' => $user]);
        
        // $jumlahPengguna = UserModel::count();

        // return view('user', ['jumlahPengguna' => $jumlahPengguna]);

        // $user = UserModel::firstOrNew([
        //     'username' => 'manager33',
        //     'nama' => 'Manager Tiga Tiga',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ]);

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ]);
        // $user->username = 'manager12';

        // $user->save();

        // $user->wasChanged();
        // $user->wasChanged('username');
        // $user->wasChanged(['username', 'level_id']);
        // $user->wasChanged('nama');
        // dd($user->wasChanged(['nama', 'username']));

        // $user = UserModel::all();
        $user = UserModel::with('level')->get();

        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request) 
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make("$request->password"),
            'level_id' => $request->level_id,
        ]);
        return redirect('/user');
    }

    public function ubah($id) 
    {
        $user = UserModel::find(($id));
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make("$request->password");
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}