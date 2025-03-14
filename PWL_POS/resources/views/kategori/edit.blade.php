@extends('layouts.app')
 
{{--Customize layout sections--}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Kategori</div>
            <div class="card-body">
                <form method="post" action="{{route('kategori.update', $data->kategori_id)}}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="namaKategori">Kategori Kode</label>
                        <input type="text" class="form-control" id="kodeKategori" name="kodeKategori" value="{{$data->kategori_kode}}">
                    </div>

                    <div class="form-group">
                        <label for="namaKategori">Kategori Nama</label>
                        <input type="text" class="form-control" id="namaKategori" name="namaKategori" value="{{$data->kategori_nama}}">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-secondary" href="{{url('/kategori')}}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection