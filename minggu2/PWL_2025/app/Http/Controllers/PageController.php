<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index () {
        return 'Selamat Datang';
    }

    public function about () {
        return 'Nama : Fahmi Yahya <br> NIM : 2341720089';

    }

    public function articles ($articleID) {
        return 'Halaman artikel dengan Id {' . $articleID . '}';
    }
}
