<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah" class="modal-dialog-centered">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg flex-fill" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('penjualan/ajax') }}" class="form-horizontal" id="form-tambah">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Pembeli</label>
                        <div class="col-10">
                                <input type="text" class="form-control" id="pembeli" name="pembeli"
                                value="{{ old('pembeli') }}" required>
                            @error('pembeli')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Kode Penjualan</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
                                value="{{ old('penjualan_kode', $initialPenjualanKode) }}" required>
                            @error('penjualan_kode')
                                <small id="error-penjualan_kode" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" style="flex-wrap: nowrap">
                        <label class="col-2 control-label col-form-label">Item Barang</label>
                        <div id="barang_list" class="col-10">
                            <div class="row mt-2">
                                <div class="col-5">
                                    <select class="form-control" id="barang_id_0" name="barang_id[]" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('barang_id')
                                        <small id="error-barang_id"
                                            class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <input type="number" class="form-control" id="jumlah_0" placeholder="Jumlah" name="jumlah[]" required>
                                    @error('jumlah')
                                        <small id="error-jumlah" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-sm btn-danger" onclick="removeBarang(this)"><i class="fa fa-trash-alt"></i></button>
                                </div>
                            </div>
                            <div class="row mt-2" id="add-list">
                                <div class="col-1">
                                    <button type="button" class="btn btn-sm btn-success"
                                        onclick="addBarang()"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
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
    function addBarang() {
        var count = $('#barang_list .row').length;
        var html = `
            <div class="row mt-2">
                <div class="col-5">
                    <select class="form-control" id="barang_id_${count}" name="barang_id[]" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Jumlah" id="jumlah_${count}" name="jumlah[]" required>
                </div>
                <div class="col-1">
                    <button class="btn btn-sm btn-danger" onclick="removeBarang(this)"><i class="fa fa-trash-alt"></i></button>
                </div>
            </div>
        `;
        $('#add-list').before(html);
    }

    function removeBarang(obj) {
        $(obj).parent().parent().remove();
    }

    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                user_id: {
                    required: true,
                    number: true
                },
                penjualan_kode: {
                    required: true,
                },
                penjualan_tanggal: {
                    required: true,
                    date: true
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
