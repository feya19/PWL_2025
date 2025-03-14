@extends('layouts.app')
 
{{--Customize layout sections--}}

@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Level</div>
            <div class="card-body">
                <form method="post" action="{{route('level.update', $data->level_id)}}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="namaLevel">Kode Level</label>
                        <input type="text" class="form-control" id="kodeLevel" name="kodeLevel" value="{{$data->level_kode}}" required>
                    </div>

                    <div class="form-group">
                        <label for="namaLevel">Nama Level</label>
                        <input type="text" class="form-control" id="namaLevel" name="namaLevel" value="{{$data->level_nama}}" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-secondary" href="{{url('/level')}}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection