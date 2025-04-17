<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monolog\Level;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register()
    {
        $levels = LevelModel::get();
        return view('auth.register', compact('levels'));
    }

    public function postRegister(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|string|min:6|confirmed',
            ]);
            $level = LevelModel::firstOrCreate([
                'level_kode' => 'CUS',
                'level_nama' => 'Pelanggan'
            ]);
            UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => $request->password,
                'level_id' => $level->level_id
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Registrasi berhasil! Silahkan login.',
                'redirect' => route('login')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Registrasi gagal: '. $e->getMessage(),
            ]);
        }
    }
}