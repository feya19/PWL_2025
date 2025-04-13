<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Harga Beli</th>
                    <td>{{ number_format($barang->harga_beli, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Harga Jual</th>
                    <td>{{ number_format($barang->harga_jual, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $barang->kategori->kategori_nama }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>