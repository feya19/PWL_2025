<html>

@include('layouts.dompdf-head')

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center"><img width="100%" src="{{ public_path('polinema-bw.png') }}"></td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN
                    PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI
                    MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang
                    65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-
                    105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <h3 class="text-center">LAPORAN DATA PENJUALAN</h4>
        <table class="border-all">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kode Penjualan</th>
                    <th>Tanggal</th>
                    <th>User/Petugas</th>
                    <th>Pelanggan</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $item)
                    @php
                        $rowspan = $item->penjualanDetail->count();
                        $total = $item->penjualanDetail->sum(function ($detail) {
                            return $detail->harga * $detail->jumlah;
                        });
                    @endphp
        
                    @foreach ($item->penjualanDetail as $index => $detail)
                        <tr>
                            @if ($index === 0)
                                <td class="text-center" rowspan="{{ $rowspan }}">{{ $loop->parent->iteration }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $item->penjualan_kode }}</td>
                                <td rowspan="{{ $rowspan }}">{{ \Carbon\Carbon::parse($item->penjualan_tanggal)->format('j M Y H:i') }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $item->user->nama }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $item->pembeli }}</td>
                            @endif
        
                            <td>{{ $detail->barang->barang_kode ?? '-' }}</td>
                            <td>{{ $detail->barang->barang_nama ?? '-' }}</td>
                            <td class="text-right">{{ number_format($detail->harga, 2, ',', '.') }}</td>
                            <td class="text-right">{{ $detail->jumlah }}</td>
                            <td class="text-right">{{ number_format($detail->harga * $detail->jumlah, 2, ',', '.') }}</td>
        
                            @if ($index === 0)
                                <td class="text-right" rowspan="{{ $rowspan }}">{{ number_format($total, 2, ',', '.') }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        
</body>

</html>
