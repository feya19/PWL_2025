@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('penjualan/' . $penjualan->penjualan_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!}

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Pembeli</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="pembeli" name="pembeli"
                            value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                        @error('pembeli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kode Penjualan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
                            value="{{ old('penjualan_kode', $penjualan->penjualan_kode) }}" required>
                        @error('penjualan_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Tanggal Penjualan</label>
                    <div class="col-11">
                        <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal"
                            value="{{ old('penjualan_tanggal', $penjualan->penjualan_tanggal ? date('Y-m-d', strtotime($penjualan->penjualan_tanggal)) : '') }}"
                            required>
                        @error('penjualan_tanggal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row" style="flex-wrap: nowrap">
                    <label class="col-1 control-label col-form-label">Item Barang</label>
                    <div id="barang_list" class="w-100">
                        @foreach ($penjualanDetail as $index => $item)
                            <div class="row mt-2">
                                <div class="col-5">
                                    <label class="control-label col-form-label">Nama Barang</label>
                                    <select class="form-control" id="barang_nama_{{ $index }}" name="barang_nama[]"
                                        required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barang as $barang_item)
                                            <option value="{{ $barang_item->barang_nama }}"
                                                @if ($barang_item->barang_nama == $item->barang->barang_nama) selected @endif>
                                                {{ $barang_item->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('barang_nama')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label class="control-label col-form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah_{{ $index }}"
                                        name="jumlah[]" value="{{ old('jumlah.' . $index, $item->jumlah) }}" required>
                                    @error('jumlah')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-sm btn-danger" onclick="removeBarang(this)">-</button>
                                </div>
                            </div>
                        @endforeach
                        <div class="row mt-2">
                            <div class="col-1">
                                <button class="btn btn-sm btn-success" onclick="addBarang()">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function addBarang() {
            var count = $('#barang_list .row').length;
            var html = `
            <div class="row mt-2">
                <div class="col-5">
                    <select class="form-control" id="barang_nama_${count}" name="barang_nama[]" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_nama }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" id="jumlah_${count}" name="jumlah[]" required>
                </div>
                <div class="col-1">
                    <button class="btn btn-sm btn-danger" onclick="removeBarang(this)">-</button>
                </div>
            </div>
        `;
            $('#barang_list').append(html);
        }

        function removeBarang(obj) {
            $(obj).parent().parent().remove();
        }
    </script>
@endpush
