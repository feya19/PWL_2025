<table class="table table-bordered table-striped table-hover table-sm">
    <tr>
        <th>Nama Barang</th>
        <td>{{ $stok->barang->barang_nama }}</td>
    </tr>
    <tr>
        <th>Nama Supplier</th>
        <td>{{ $stok->supplier->supplier_nama }}</td>
    </tr>
    <tr>
        <th>Stok Tanggal</th>
        <td>{{ Carbon\Carbon::parse($stok->stok_tanggal)->format('j M Y') }}</td>
    </tr>
    <tr>
        <th>Stok Jumlah</th>
        <td>{{ $stok->stok_jumlah }}</td>
    </tr>
</table>