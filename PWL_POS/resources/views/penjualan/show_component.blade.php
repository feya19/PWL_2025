<table class="table table-bordered table-striped table-hover table-sm">
    <tr>
        <th>User/Petugas</th>
        <td>{{ $penjualan->user->nama }}</td>
    </tr>
    <tr>
        <th>Pembeli</th>
        <td>{{ $penjualan->pembeli }}</td>
    </tr>
    <tr>
        <th>Kode Penjualan</th>
        <td>{{ $penjualan->penjualan_kode }}</td>
    </tr>
    <tr>
        <th>Tanggal</th>
        <td>{{ Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('j M Y H:i') }}</td>
    </tr>
    <tr>
        <th>Tanggal Diubah</th>
        <td>{{ $penjualan->penjualan_tanggal == $penjualan->updated_at ? '-' : Carbon\Carbon::parse($penjualan->updated_at)->format('j M Y H:i') }}</td>
    </tr>
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($detail as $item)
                <tr>
                    <td>{{ $item->barang->barang_kode }}</td>
                    <td>{{ $item->barang->barang_nama }}</td>
                    <td>{{ number_format($item->harga, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->jumlah) }}</td>
                    <td>{{ number_format($item->harga * $item->jumlah, 2, ',', '.') }}</td>
                </tr>
                @php
                    $total += $item->harga * $item->jumlah;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-center">Total</th>
                <th>Rp. {{ number_format($total, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</table>
