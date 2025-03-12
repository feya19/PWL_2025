<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('kategori.index');
    }
}
