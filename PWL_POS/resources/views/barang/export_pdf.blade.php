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
    <h3 class="text-center">LAPORAN DATA BARANG</h4>
        <table class="border-all">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Harga Jual</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $b)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $b->barang_kode }}</td>
                        <td>{{ $b->barang_nama }}</td>
                        <td class="text-right">{{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $b->kategori->kategori_nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>

</html>
