<x-app-layout title="Transaksi">
    <div class="my-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">Transaksi</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="p-0 mb-4 shadow card">
                <div class="card-body">
                    <div class="form-group row">
                        <x-input-label for="kode_transaksi" class="col-sm-3 col-form-label" value="Kode Transaksi" required/>
                        <div class="col-sm-9">
                            <x-text-input for="invoice_kode" type="text" name="invoice_kode" id="invoice" :value="$invoiceKode" readonly />
                            <x-input-error record="invoice_kode" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <x-input-label for="tanggal" class="col-sm-3 col-form-label" value="Tanggal" />
                        <div class="col-sm-9">
                            <x-text-input for="tanggal" type="text" name="tanggal" id="tanggal" :value="Carbon\Carbon::now()->format('d F Y')" readonly />
                            <x-input-error record="tanggal" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-4 shadow card">
                <div class="card-body">
                    <div class="pb-3 mt-3 row">
                        <div class="col">
                            <h1 class="mt-0 mb-1 text-right tampilHarga"></h1>
                            <p class="mb-1 text-right small text-muted">Total Harga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="mb-4 shadow card">
                <div class="card-header">
                    <strong class="card-title">Identitas Customer</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.save') }}" id="storeData" method="POST">
                        @csrf
                        <input type="hidden" name="data" id="storeProduk">
                        <div class="mb-3 form-group">
                            <x-input-label for="nama" value="Nama" />
                            <x-text-input for="nama" type="text" id="nama_customer" name="nama" :value="old('nama_customer')" autofocus required />
                            <x-input-error record="nama" />
                        </div>
                        <div class="mb-3 form-group">
                            <x-input-label for="email" value="Email" />
                            <x-text-input for="email" type="email" id="email_customer" name="email" :value="old('email_customer')" autofocus required />
                            <x-input-error record="email" />
                        </div>
                        <div class="mb-3 form-group">
                            <x-input-label for="no_telp" value="Nomor Telepon" />
                            <div class="mb-1 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                </div>
                                <x-text-input for="no_telp" type="number" id="no_telp_customer" name="no_telp" :value="old('no_telp')" autofocus required />
                                <x-input-error record="no_telp" />
                            </div>
                            <span class="mt-0 help-block"><small>Input angka saja.</small></span>
                        </div>
                        <div class="mb-3 form-group">
                            <x-input-label for="alamat" value="Alamat Pengiriman" />
                            <textarea name="alamat" rows="10" class="form-control" id="alamat_customer" required>{{ old('alamat') }}</textarea>
                            <x-input-error record="alamat" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-0 col-12 col-md-8" >
            <div class="shadow card" style="height: 95%;">
                <div class="card-header">
                    <strong class="card-title">Item</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3 form-inline">
                        <select class="form-control select2 @if($errors->has('produk')) is-invalid @endif my-1 mr-sm-2" style="width: 300px" id="simple-select2" name="produk" required>
                            <option value="0" selected>...</option>
                            @foreach ($produk as $item)
                            <option value="{{ $item->kode_produk }}">
                                <div class="col">
                                    <small><strong>[ {{ $item->kode_produk }} ] {{ $item->nama }} [ Stok : {{ $item->stok }} ]</strong></small>
                                </div>
                            </option>
                            @endforeach
                        </select>
                        <x-input-error record="bahanBaku" />
                        <input type="number" class="mt-2 ml-0 ml-md-2 mt-md-0 form-control jumlahProduk" style="width: 100px" placeholder="Jumlah" min="0" onkeypress="return isNumberKey(event);">
                        <button type="button" class="mt-2 ml-0 tambah_produk ml-md-2 mt-md-0 btn btn-primary">Tambah</button>
                    </div>
                    <div id="tabel_produk">
                        <table class="table mb-0 table-hover">
                            <thead class="thead-dark" style="color: #ffffff;background-color: #343a40;border-color: #454d55;">
                                <tr>
                                    <td align="center">#</td>
                                    <td width="40%">Nama</td>
                                    <td width="10%" align="center">Jumlah</td>
                                    <td align="right">Harga</td>
                                    <td align="right">Harga Total</td>
                                    <td align="center" >Aksi</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="button" id="reset_produk" class="btn btn-secondary" data-dismiss="modal">Reset Transaksi</button>
                    <button type="submit" id="simpan_produk" class="ml-2 btn btn-success">Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            resetProduk();
            $('#tabel_produk').hide();
            var produk = [];
            var no = 0;
            var totalBiayaProduk = 0;

            $("body").addClass("collapsed");

            $(".select2").select2({
                theme: "bootstrap4",
            });

            // Ketika bahan baku terselect
            $(".tambah_produk").on("click", function () {
                let optionValue = $(".select2 option:selected").val();
                let jumlahProduk = $(".jumlahProduk").val();
                if (optionValue != "0" && jumlahProduk != "" && jumlahProduk != "0") {
                    $.ajax({
                        type: "GET",
                        url: "/transaksi/get-data-produk",
                        data: {
                            kode_produk: optionValue,
                            jumlah: jumlahProduk,
                        },
                        dataType: "json",
                        success: function (response) {
                            // Jika bahan baku belum terselect sebelumnya
                            if(checkData(response) == true){
                                if(checkStok(optionValue, jumlahProduk) == true){
                                    resetProduk();
                                    tabelProduk(response);
                                }else{
                                    resetProduk();
                                    loadTabel();
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Stok produk tidak mencukupi.',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            }else{
                                // Jika bahan baku sudah terselect sebelumnya
                                resetProduk();
                                loadTabel();
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Produk sudah terpilih.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                    });
                }
            });

            // Cek apakah data yg terselect sama
            function checkData(data) {
                $isValid = true;
                produk.forEach(function(item) {
                    if (item['produk']['kode_produk'] == data['produk']['kode_produk']) {
                        $isValid = false;
                    }
                });
                return $isValid;
            }

            // Cek Jumlah Stok
            function checkStok(option, jumlahProduk) {
                var ajax = $.ajax({
                    type: "GET",
                    url: "/transaksi/cek-stok-produk",
                    data: {
                        kode_produk: option,
                        jumlah: jumlahProduk,
                    },
                    async: false,
                    dataType: "json",
                });

                if (ajax.responseText == 'true') {
                    return true;
                }
                return false;
            }

            // Simpan Produk
            $("#simpan_produk").on("click", function () {
                if (cekInputValidasi()) {
                    var dataProduk = {};
                    dataProduk["invoice"] = $('#invoice').val();
                    dataProduk["tanggal"] = $('#tanggal').val();

                    dataProduk["nama_customer"] = $('#nama_customer').val();
                    dataProduk["no_telp_customer"] = $('#no_telp_customer').val();
                    dataProduk["alamat_customer"] = $('#alamat_customer').val();
                    dataProduk["email_customer"] = $('#email_customer').val();

                    dataProduk["transaksi"] = produk;
                    dataProduk["total"] = totalBiayaProduk;

                    $('#storeProduk').val(JSON.stringify(dataProduk));
                    $('#storeData').submit();
                }
            });

            function cekInputValidasi(){
                if ($('#nama_customer').val() == "" || cekNoTelp($('#no_telp_customer').val()) || $('#alamat_customer').val() == "" || $('#email_customer').val() == "") {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Mohon melengkapi pengisian form.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
                return true;
            }

            function cekNoTelp(telp){
                if (telp == "" && !$.isNumeric(telp)) {
                    return true;
                }
                return false;
            }

            // Push data ke array produk
            function tabelProduk(data) {
                totalBiayaProduk += hitungHarga(data['produk']['harga_jual'], data['jumlah'])
                produk.push(data);
                loadTabel();
            }

            // Menghitung total harga
            function hitungHarga(harga, jumlah){
                let totalHarga = parseInt(harga) * parseInt(jumlah);
                return totalHarga;
            }

            // Load data dari array
            function loadTabel(){
                $('#tabel_produk').show();

                if (produk.length == 0) {
                    $('#tabel_produk').hide();
                    $("#simpan_produk").attr('disabled', 'disabled');
                }

                if (produk.length != 0) {
                    $("#simpan_produk").removeAttr('disabled');
                }

                no = 1;
                $('#tabel_produk tbody').html("");

                // Isi tabel
                $.each(produk, function (key, item) {
                    $('#tabel_produk tbody').append('<tr><td align="center">'+(no++)+'</td><td>'+item['produk']['nama']+'</td><td align="center">'+item['jumlah']+'</td><td align="right">Rp. '+formatRupiah(item['produk']['harga_jual'])+'</td><td align="right">Rp. '+formatRupiah(item['total'])+'</td><td align="center"><button type="button" class="btn btn-sm btn-danger delete-produk" data-id="'+key+'"><i class="fe fe-trash-2"></i></button></td></tr>')
                });

                // Tampilkan harga
                var total = (totalBiayaProduk <= null) ? 0 : formatRupiah(parseInt(totalBiayaProduk));
                $('.tampilHarga').html('Rp. '+ total);
            }

            function resetProduk() {
                $("#simpan_produk").attr('disabled', 'disabled');
                $(".select2").val("0").change();
                $(".jumlahProduk").val("");
                $('.tampilHarga').html("Rp. 0")
            }

            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix) {
                var number_string = angka.toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
            }

            // Hapus bahan baku
            $('#tabel_produk').on('click','button.delete-produk', function(){
                hapusProduk($(this).data('id'));
                loadTabel();
            });

            // Hapus produk dari array
            function hapusProduk(id){
                var harga = (parseInt(produk[id]['produk']['harga_jual']) * parseInt(produk[id]['jumlah']));
                produk.splice(id, 1);
                totalBiayaProduk = parseInt(totalBiayaProduk) - parseInt(harga);
                resetProduk();
                loadTabel();
            }

            // Hapus produk
            $('#reset_produk').on('click', function(){
                produk = [];
                produk["total"] = 0;
                resetProduk();
                loadTabel();
            });
        });
    </script>
    @endpush
</x-app-layout>
