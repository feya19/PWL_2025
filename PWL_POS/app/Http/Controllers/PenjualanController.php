<?php

namespace App\Http\Controllers;

use App\DataTables\PenjualanDataTable;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function indexSelf()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan Sendiri']
        ];

        $page = (object)[
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan_self';

        return view('penjualan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'self' => true
        ]);
    }

    public function list(Request $request)
    {
        $sales = PenjualanModel::with(['user', 'penjualanDetail'])->select(
            'penjualan_id',
            'user_id',
            'pembeli',
            'penjualan_kode',
            'penjualan_tanggal'
        );

        return DataTables::of($sales)
            ->addIndexColumn()
            ->editColumn('penjualan_tanggal', function($sale) {
                return Carbon::parse($sale->penjualan_tanggal)->format('j M Y H:i');
            })
            ->addColumn('total', function ($sale) {
                $total = $sale->penjualanDetail->sum(function ($detail) {
                    return $detail->harga * $detail->jumlah;
                });
                return 'Rp. '. number_format($total, 2, ',', '.');
            })
            ->addColumn('aksi', function ($sale) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $sale->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $sale->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $sale->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah penjualan baru'
        ];

        $activeMenu = 'penjualan';
        $user = UserModel::get();
        $barang = BarangModel::get();
        $initialPenjualanKode = 'P-' .  PenjualanModel::orderBy('penjualan_id', 'desc')->value('penjualan_id') + 1;

        return view('penjualan.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'barang' => $barang,
            'initialPenjualanKode' => $initialPenjualanKode,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create_ajax()
    {
        $user = UserModel::get();
        $barang = BarangModel::get();
        $initialPenjualanKode = 'P-' .  PenjualanModel::orderBy('penjualan_id', 'desc')->value('penjualan_id') + 1;

        return view('penjualan.create_ajax', [
            'user' => $user,
            'barang' => $barang,
            'initialPenjualanKode' => $initialPenjualanKode
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|string|max:50',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $pembeli = UserModel::find($request->user_id)->nama;
        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
        ]);

        foreach ($request->barang_nama as $key => $barang_nama) {
            $barang_id = BarangModel::where('barang_nama', $barang_nama)->first()->barang_id;
            $harga = BarangModel::where('barang_id', $barang_id)->first()->harga_jual;

            $stok = StokModel::where('barang_id', $barang_id)->first();
            if (!empty($stok) && $request->kurangi_stok) {
                $stok->update([
                    'stok_jumlah' => $stok->stok_jumlah - $request->jumlah[$key],
                ]);
            }

            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang_id,
                'jumlah' => $request->jumlah[$key],
                'harga' => $harga
            ]);
        }

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'pembeli' => 'required|string|max:50',
                'penjualan_kode' => 'required|string|max:20|unique:t_penjualan,penjualan_kode',
                'barang_id' => 'required|array',
                'barang_id.*' => 'required|string|max:50',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            DB::beginTransaction();
            try {
                $pembeli = $request->pembeli;
                $user_id = auth()->user()->user_id;
                $penjualan = PenjualanModel::create([
                    'user_id' => $user_id,
                    'pembeli' => $pembeli,
                    'penjualan_kode' => $request->penjualan_kode,
                    'penjualan_tanggal' => now(),
                ]);

                $barangIdArray = $request->barang_id;
                $penjualanDetail = [];
                $barangs = BarangModel::whereIn('barang_id', $barangIdArray)->get();
                foreach ($barangIdArray as $key => $barang_id) {
                    $barang = $barangs->where('barang_id', $barang_id)->first();
                    if (empty($barang)) {
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => 'Barang ID '. $barang_id . ' Tidak Ditemukan'
                        ]);
                    }
                    $harga = $barang->harga_jual;
                    $stok = StokModel::where('barang_id', $barang_id)->first();
                    if (empty($stok)) {
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => 'Stok '. $barang->barang_nama . ' Tidak Ditemukan'
                        ]);
                    }
                    if ($stok->stok_jumlah - $request->jumlah[$key] < 0) {
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => 'Stok '. $barang->barang_nama . ' Tidak Mencukupi. Tersisa: '. $stok->stok_jumlah
                        ]);
                    } 
                    $stok->update([
                        'stok_jumlah' => $stok->stok_jumlah - $request->jumlah[$key],
                        'updated_at' => now()
                    ]);
                    $penjualanDetail[] = [
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $barang_id,
                        'jumlah' => $request->jumlah[$key],
                        'harga' => $harga
                    ];
                }
                PenjualanDetailModel::insert($penjualanDetail);
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil disimpan'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan gagal disimpan'
                ]);
            }
        }
    }

    public function show(string $id)
    {
        $penjualan = PenjualanModel::with('user')->find($id);
        $detail = PenjualanDetailModel::with('barang')->where('penjualan_id', $id)->get();

        $breadcrumb = (object) [
            'title' => 'Detail penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'detail' => $detail,
            'activeMenu' => $activeMenu
        ]);
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->find($id);

        return view('penjualan.show_ajax', [
            'penjualan' => $penjualan,
            'detail' => $penjualan->penjualanDetail,
        ]);
    }

    public function edit(string $id)
    {
        $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->find($id);
        $user = UserModel::get();
        $barang = BarangModel::get();

        $breadcrumb = (object) [
            'title' => 'Edit Penjualan',
            'list' => ['Home', 'Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'penjualanDetail' => $penjualan->penjualanDetail,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->find($id);
        $user = UserModel::get();
        $barang = BarangModel::get();

        return view('penjualan.edit_ajax', [
            'penjualan' => $penjualan,
            'penjualanDetail' => $penjualan->penjualanDetail,
            'barang' => $barang,
            'user' => $user
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|string|max:50',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $pembeli = UserModel::find($request->user_id)->nama;
        $penjualan = PenjualanModel::find($id);
        $penjualan->update([
            'user_id' => $request->user_id,
            'pembeli' => $pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
        ]);

        $penjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)->get();
        $barangIdArray = $request->barang_id;
        foreach ($barangIdArray as $key => $barang) {
            $barang_id = $barang->barang_id;
            $harga = BarangModel::where('barang_id', $barang_id)->first()->harga_jual;
            $check = $penjualanDetail->where('barang_id', $barang_id)->first();
            if ($check) {
                $check->update([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $harga
                ]);
            } else {
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $harga
                ]);
            }
        }

        foreach ($penjualanDetail as $detail) {
            if (!in_array($detail->barang_id, $barangIdArray)) {
                $detail->delete();
            }
        }

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }

    public function update_ajax(Request $request, string $id)
    {
        $rules = [
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|string|max:50',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        DB::beginTransaction();
        try {
            $pembeli = $request->pembeli;
            $user_id = auth()->user()->user_id;
            $penjualan = PenjualanModel::find($id);
            $penjualan->update([
                'user_id' => $user_id,
                'pembeli' => $pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'updated_at' => now()
            ]);

            $penjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)->get();
            $barangIdArray = $request->barang_id;
            $barangs = BarangModel::whereIn('barang_id', $barangIdArray)->get();
            foreach ($barangIdArray as $key => $barang_id) {
                $barang = $barangs->where('barang_id', $barang_id)->first();
                if (empty($barang)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Barang ID '. $barang_id . ' Tidak Ditemukan'
                    ]);
                }
                $harga = $barang->harga_jual;
                $check = $penjualanDetail->where('barang_id', $barang_id)->first();
                
                $stok = StokModel::where('barang_id', $barang_id)->first();
                if (empty($stok)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stok '. $barang->barang_nama . ' Tidak Ditemukan'
                    ]);
                }
            
                $total_stok = $stok->stok_jumlah;
                if ($check) {
                    $total_stok += $check->jumlah;
                }

                if ($total_stok - $request->jumlah[$key] < 0) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stok '. $barang->barang_nama . ' Tidak Mencukupi. Tersisa: '. $total_stok
                    ]);
                } 

                $stok->update([
                    'stok_jumlah' => $total_stok - $request->jumlah[$key],
                    'updated_at' => now()
                ]);
                
                PenjualanDetailModel::updateOrCreate([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id
                ], [
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $harga
                ]);
            }


            foreach ($penjualanDetail as $detail) {
                if (!in_array($detail->barang_id, $barangIdArray)) {
                    $stok = StokModel::where('barang_id', $detail->barang_id)->first()?->update([
                        'stok_jumlah' => DB::raw('stok_jumlah + '.$detail->jumlah),
                        'updated_at' => now()
                    ]);
                    $detail->delete();
                }
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil diubah'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan gagal diubah'
            ]);
        }
    }

    public function destroy(string $id)
    {
        $checkPenjualan = PenjualanModel::find($id);

        if (!$checkPenjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            PenjualanDetailModel::where('penjualan_id', $id)->delete();
            PenjualanModel::destroy($id);
            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('user')->find($id);
        $detail = PenjualanDetailModel::with('barang')->where('penjualan_id', $id)->get();

        return view('penjualan.confirm_ajax', [
            'penjualan' => $penjualan,
            'detail' => $detail,
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);

            if ($penjualan) {
                try {
                    PenjualanDetailModel::where('penjualan_id', $id)->delete();
                    $penjualan->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak bisa dihapus'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_penjualan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insertDetail = [];
            if (count($data) > 1) {
                try {
                    $kodePenjualan = '';
                    foreach ($data as $baris => $value) {
                        if ($baris > 1) {
                            if ($kodePenjualan != $value['A']) {
                                if (PenjualanModel::where('penjualan_kode', $value['A'])->first()) {
                                    continue;
                                }
                                $penjualan = PenjualanModel::create([
                                    'penjualan_kode' => $value['A'],
                                    'penjualan_tanggal' => $value['B'],
                                    'pembeli' => $value['C'],
                                    'user_id' => $value['D'],
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]);
                                $kodePenjualan = $value['A'];
                            }
                            $insertDetail[] = [
                                'penjualan_id' => $penjualan->penjualan_id,
                                'barang_id' => $value['E'],
                                'jumlah' => $value['F'],
                                'harga' => $value['G'],
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }
                    if (count($insertDetail) > 0) {
                        PenjualanDetailModel::insertOrIgnore($insertDetail);
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport'
                    ]);
                } catch (Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Tanggal Penjualan');
        $sheet->setCellValue('D1', 'User/Petugas');
        $sheet->setCellValue('E1', 'Pembeli');
        $sheet->setCellValue('F1', 'Kode Barang');
        $sheet->setCellValue('G1', 'Nama Barang');
        $sheet->setCellValue('H1', 'Harga');
        $sheet->setCellValue('I1', 'Jumlah');
        $sheet->setCellValue('J1', 'Subtotal');
        $sheet->setCellValue('K1', 'Total Penjualan');

        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        $no = 1;
        $row = 2;

        foreach ($penjualan as $item) {
            $rowspan = $item->penjualanDetail->count();
            $total = $item->penjualanDetail->sum(function ($d) {
                return $d->harga * $d->jumlah;
            });

            foreach ($item->penjualanDetail as $index => $detail) {
                if ($index === 0) {
                    $sheet->setCellValue('A' . $row, $no);
                    $sheet->setCellValue('B' . $row, $item->penjualan_kode);
                    $sheet->setCellValue('C' . $row, \Carbon\Carbon::parse($item->penjualan_tanggal)->format('j M Y H:i'));
                    $sheet->setCellValue('D' . $row, $item->user->nama ?? '-');
                    $sheet->setCellValue('E' . $row, $item->pembeli);
                }

                $sheet->setCellValue('F' . $row, $detail->barang->barang_kode ?? '-');
                $sheet->setCellValue('G' . $row, $detail->barang->barang_nama ?? '-');
                $sheet->setCellValue('H' . $row, $detail->harga);
                $sheet->setCellValue('I' . $row, $detail->jumlah);
                $sheet->setCellValue('J' . $row, $detail->harga * $detail->jumlah);

                if ($index === 0) {
                    $sheet->setCellValue('K' . $row, $total);
                    $no++;
                }

                $row++;
            }
        }

        // Auto size all used columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setTitle('Data Penjualan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, dMY H:i:s') . 'GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->get();
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url 
        $pdf->render();
        return $pdf->stream('Data Barang ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
