<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah" class="modal-dialog-centered">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg flex-fill" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('stok/ajax') }}" class="form-horizontal" id="form-tambah">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Barang</label>
                        <div class="col-11">
                            <select class="form-control" id="barang_id" name="barang_id" required>
                                <option value="">Barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
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
                                    <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
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
                                value="{{ old('stok_jumlah') }}" required>
                            @error('stok_jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Tanggal Stok</label>
                        <div class="col-11">
                            <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal"
                                value="{{ old('stok_tanggal') }}" required>
                            @error('stok_tanggal')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                barang_id: {
                    required: true
                },
                supplier_id: {
                    required: true
                },
                stok_jumlah: {
                    required: true
                },
                stok_tanggal: {
                    required: true
                }
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
