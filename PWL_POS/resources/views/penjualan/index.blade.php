@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            @if (!isset($self))
                <div class="card-tools">
                    <a href="{{ url('penjualan/export_excel') }}" class="btn btn-sm btn-primary mt-1">
                        <i class="fa fa-file-excel"></i>
                        Export Excel
                    </a>
                    <a href="{{ url('penjualan/export_pdf') }}" class="btn btn-sm btn-warning mt-1">
                        <i class="fa fa-file-pdf"></i>
                        Export PDF
                    </a>
                    <button onclick="modalAction('{{ url('penjualan/create_ajax') }}')" class="btn btn-sm btn-primary mt-1">
                        Tambah
                    </button>
                </div>
            @endif
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User/Petugas</th>
                        <th>Pembeli</th>
                        <th>Kode Penjualan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        var dataUser;
        $(document).ready(function() {
            dataUser = $('#table_penjualan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "user.nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pembeli",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penjualan_kode",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penjualan_tanggal",
                        className: "",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "total",
                        className: "text-right",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "text-nowrap",
                        width: "1",
                        orderable: false,
                        searchable: false
                    }
                ],
                autoWidth: false,
            });
        });
    </script>
@endpush
