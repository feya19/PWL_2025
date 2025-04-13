@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content flex-fill">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content flex-fill">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('stok/' . $stok->stok_id . '/update_ajax') }}" class="form-horizontal"
                id="form-edit">
                @csrf
                {!! method_field('PUT') !!}
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Barang</label>
                        <div class="col-11">
                            <select class="form-control" id="barang_id" name="barang_id" required readonly disabled>
                                <option value="">Barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $stok->barang->barang_id }}"
                                        @if ($item->barang_id == $stok->barang->barang_id) selected @endif>
                                        {{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Supplier</label>
                        <div class="col-11">
                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                <option value="">Supplier</option>
                                @foreach ($supplier as $item)
                                    <option value="{{ $stok->supplier->supplier_id }}"
                                        @if ($item->supplier_id == $stok->supplier->supplier_id) selected @endif>
                                        {{ $item->supplier_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jumlah</label>
                        <div class="col-11">
                            <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah"
                                value="{{ old('stok_jumlah', $stok->stok_jumlah) }}" required>
                            @error('stok_jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Tanggal Stok</label>
                        <div class="col-11">
                            <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal"
                                value="{{ old('stok_tanggal', $stok->stok_tanggal ? date('Y-m-d', strtotime($stok->stok_tanggal)) : '') }}"
                                required>
                            @error('stok_tanggal')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    barang_id: {
                        required: true
                    },
                    supplier_id: {
                        required: true
                    },
                    stok_jumlah: {
                        required: true,
                        number: true
                    },
                    stok_tanggal: {
                        required: true,
                        date: true
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataUser.ajax.reload(null, false);
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
