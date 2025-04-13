<?php
 
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index() 
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];

        $activeMenu = 'dashboard';

        return view('welcome', compact('breadcrumb', 'activeMenu'));
    }

    public function penjualanPerHariIni()
    {
        $total = DB::table('t_penjualan as tp')
            ->join('t_penjualan_detail as td', 'tp.penjualan_id', '=', 'td.penjualan_id')
            ->select(DB::raw('SUM(td.harga * td.jumlah) as total'))
            ->value('total');

        return response()->json([
            'total' => number_format($total ?? 0, 2, ',', '.')
        ]);
    }
    
    public function labaPerHariIni()
    {
        $total = DB::table('t_penjualan_detail as pd')
            ->join('m_barang as b', 'pd.barang_id', '=', 'b.barang_id')
            ->select(DB::raw('SUM((pd.harga - b.harga_beli) * pd.jumlah) as total_laba'))
            ->value('total_laba');

        return response()->json([
            'total' => number_format($total ?? 0, 2, ',', '.')
        ]);
    }

    public function topProducts()
    {
        $top = DB::table('t_penjualan_detail as d')
            ->join('m_barang as b', 'd.barang_id', '=', 'b.barang_id')
            ->select('b.barang_nama', DB::raw('SUM(d.jumlah) as total'))
            ->groupBy('d.barang_id', 'b.barang_nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json([
            'labels' => $top->pluck('barang_nama'),
            'data' => $top->pluck('total')
        ]);
    }

    public function peakHours()
    {
        $jamRamai = DB::table('t_penjualan')
            ->select(DB::raw('HOUR(penjualan_tanggal) as jam'), DB::raw('COUNT(*) as total'))
            ->groupBy('jam')
            ->orderBy('jam')
            ->get();

        return response()->json([
            'labels' => $jamRamai->pluck('jam'),
            'data' => $jamRamai->pluck('total')
        ]);
    }
}