<x-app-layout title="Tambah Barang Baku">
    @section('style')
    <style>
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: auto;
        }
        table{
            width: 100%;
        }
    </style>
    @endsection
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="page-title">Tambah Data</h2>
            <p class="text-muted">Tambah data produk per satu item.</p>

            <div class="mt-4 shadow card">
                <div class="card-header">
                    <strong class="card-title">Form Input</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea class="d-none bahanBaku-input" name="bahanBaku"></textarea>
                        <input type="hidden" class="d-none bahanBakuTotal-input" name="bahanBakuTotal" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <x-input-label for="kode_produk" value="Kode Produk" />
                                    <x-text-input for="kode_produk" type="text" name="kode_produk" :value="$kodeProduk" readonly />
                                    <x-input-error record="kode_produk" />
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="nama" value="Nama Produk" />
                                    <x-text-input for="nama" type="text" name="nama" :value="old('nama')" autofocus required />
                                    <x-input-error record="nama" />
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="deskripsi" value="Deskripsi" />
                                    <textarea name="deskripsi" rows="10" class="form-control">{{ old('deskripsi') }}</textarea>
                                    <x-input-error record="deskripsi" />
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="foto" value="Foto" />
                                    <div class="text-center col-6 col-md-3">
                                        <img src="{{ asset('produk_photo/default.jpg') }}" alt="..." class="crop-img" id="imgPreview" width="300px"/>
                                    </div>
                                    <div class="mt-3">
                                        <div class="mb-3 form-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                <input type="file" class="custom-file-input" id="foto" name="foto" />
                                            </div>
                                            @error('foto')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="simple-select2">Bahan Baku Yang Akan Digunakan</label>
                                    <select class="form-control select2 @if($errors->has('bahanBaku')) is-invalid @endif" id="simple-select2" name="bahan_baku" required>
                                        <option value="0" selected>...</option>
                                        @foreach ($bahanBaku as $bahan)
                                        <option value="{{ $bahan->slug }}">
                                            <div class="col">
                                                <small><strong>{{ $bahan->nama }}</strong></small>
                                            </div>
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error record="bahanBaku" />
                                </div>
                                <div id="tabel_bahan_baku">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <td>#</td>
                                                <td width="70%">Nama</td>
                                                <td width="30%">Jumlah</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="harga_beli" value="Harga Beli" />
                                    <div class="mb-3 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <x-text-input for="harga_beli" type="text" name="harga_beli" class="harga_beli" value="0" readonly />
                                        <x-input-error record="harga_beli" />
                                    </div>
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="harga_jual" value="Harga Jual" />
                                    <div class="mb-3 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <x-text-input for="harga_jual" id="format-rupiah" type="text" name="harga_jual" :value="currency_IDR(old('harga_jual'))" required/>
                                        <x-input-error record="harga_jual" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('produk.index') }}" class="btn btn-warning"><i class="fe fe-arrow-left"></i> Kembali</a>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- .col-12 -->
    </div>

    @section('modals')
    <div class="modal fade" id="add_bahan" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verticalModalTitle">Tambah Bahan Baku</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="slug_bahan" class="slug_bahan" />
                    <input type="hidden" name="satuan_bahan" class="satuan_bahan" />
                    <div class="form-group">
                        <x-input-label for="nama_bahan" value="Nama Bahan" />
                        <x-text-input for="nama_bahan" class="nama_bahan" type="text" name="nama_bahan" disabled />
                    </div>
                    <div class="form-group">
                        <x-input-label for="harga_bahan" value="Harga per satuan" /> : <span class="perSatuan" style="font-weight: bold;"></span>
                        <x-text-input for="harga_bahan" class="mb-1 harga_bahan" type="text" name="harga_bahan" disabled />
                    </div>
                    <hr class="mt-0" />
                    <div class="mt-1 form-group">
                        <x-input-label for="jumlah" value="Jumlah Bahan Dipakai" />
                        <x-text-input for="jumlah" type="number" name="jumlah" class="jumlah" required onkeypress="return isNumberKey(event);"/>
                        <div id="warning_bahan" class="mt-2" style="color: red;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="simpan_bahan_baku" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection @push('scripts')
    <script src="{{ asset('js/rupiahFormat.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#tabel_bahan_baku').hide();
            var bahanBaku = [];
            var no = 0;
            bahanBaku["total"] = 0;

            $(".select2").select2({
                theme: "bootstrap4",
            });

            // Preview Foto
            $("#foto").change(function () {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $("#imgPreview").attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Ketika bahan baku terselect
            $(".select2").on("change", function () {
                resetBahanBaku();
                let optionValue = $(".select2 option:selected").val();
                if (optionValue != "0") {
                    $.ajax({
                        type: "GET",
                        url: "/produk/get_data_bahan_baku",
                        data: {
                            slug: optionValue,
                        },
                        dataType: "json",
                        success: function (response) {
                            if(checkData(response) == true){
                                // Jika bahan baku belum terselect sebelumnya
                                $("#add_bahan").modal("show");
                                $(".nama_bahan").val(response.nama);
                                $(".slug_bahan").val(response.slug);
                                $(".harga_bahan").val(response.harga);
                                $(".perSatuan").html(response.satuan);
                                $(".satuan_bahan").val(response.satuan);
                                $(".stok_bahan").val(response.stok);
                            }else{
                                // Jika bahan baku sudah terselect sebelumnya
                                resetBahanBaku();
                                $(".select2").val("0").change();
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Bahan baku sudah terpilih.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                    });
                }
            });

            // Ketika close modal, reset select dan form modal
            $("#add_bahan").on("hidden.bs.modal", function () {
                $(".select2").val("0").change();
                resetBahanBaku();
            });

            // Simpan Bahan Baku
            $("#simpan_bahan_baku").on("click", function () {
                var dataBahanBaku = {};
                // Ambil dari form input modal
                let namaBahan = $(".nama_bahan").val();
                let slugBahan = $(".slug_bahan").val();
                let hargaBahan = $(".harga_bahan").val();
                let jumlahDiminta = $(".jumlah").val();
                let satuanBahan = $(".satuan_bahan").val();

                dataBahanBaku["nama"] = namaBahan;
                dataBahanBaku["slug"] = slugBahan;
                dataBahanBaku["harga"] = splitHarga(hargaBahan);
                dataBahanBaku["harga_total"] = parseInt(splitHarga(hargaBahan)) * parseInt(jumlahDiminta);
                dataBahanBaku["jumlah"] = jumlahDiminta;
                dataBahanBaku["satuan"] = satuanBahan;

                // Tambahkan ke array bahanBaku
                tabelBahanBaku(dataBahanBaku);
                $("#add_bahan").modal("hide");
            });

            // Hapus bahan baku
            $('#tabel_bahan_baku').on('click','button.delete-bahan', function(){
                hapusBahanBaku($(this).data('id'));
                loadTabel()
            });

            // Cek Jumlah Stok
            // $(".jumlah").on("keyup", function () {
            //     $("#warning_bahan").html("");
            //     $("#simpan_bahan_baku").attr("disabled", "disabled");
            //     let jumlahDiminta = $(".jumlah").val();
            //     let slugBahan = $(".slug_bahan").val();

            //     if (jumlahDiminta != "") {
            //         if (jumlahDiminta != "0") {
            //             $.ajax({
            //                 type: "GET",
            //                 url: "/produk/cek_stok_bahan_baku",
            //                 data: {
            //                     jumlah: jumlahDiminta,
            //                     slug: slugBahan,
            //                 },
            //                 dataType: "json",
            //                 success: function (response) {
            //                     if (response.isValid == false) {
            //                         $("#warning_bahan").html("Stok tidak mencukupi!");
            //                         $("#simpan_bahan_baku").attr("disabled", "disabled");
            //                     } else {
            //                         $("#simpan_bahan_baku").removeAttr("disabled");
            //                     }
            //                 },
            //             });
            //         }
            //     }
            // });

            function resetBahanBaku() {
                $("#warning_bahan").html("");
                $(".nama_bahan").val("");
                $(".slug_bahan").val("");
                $(".harga_bahan").val("");
                $(".stok_bahan").val("");
                $(".jumlah").val("");
                $(".slug_bahan").val("");
                $("#simpan_bahan_baku").removeAttr("disabled");
            }

            // Push data ke array bahan baku
            function tabelBahanBaku(data) {
                bahanBaku["total"] += hitungHarga(data['harga'], data['jumlah'])
                no = 1;
                bahanBaku.push(data);
                $('.bahanBaku-input').val(JSON.stringify(bahanBaku));
                $('.bahanBakuTotal-input').val(bahanBaku['total']);
                loadTabel();
            }

            // Menghitung total harga
            function hitungHarga(harga, jumlah){
                let totalHarga = parseInt(harga) * parseInt(jumlah);
                return totalHarga;
            }

            // Split angka pada harga
            function splitHarga(harga) {
                var split1 = harga.split(".").join("");
                var split2 = split1.split("Rp ").join("");
                return split2;
            }

            // Cek apakah data yg terselect sama
            function checkData(data) {
                $isValid = true;
                bahanBaku.forEach(function(item) {
                    if (item['slug'] == data['slug']) {
                        $isValid = false;
                    }
                });
                return $isValid;
            }

            // Load data dari array
            function loadTabel(){
                $('#tabel_bahan_baku').show();

                if (bahanBaku.length == 0) {
                    $('#tabel_bahan_baku').hide();
                }

                no = 1;
                $('#tabel_bahan_baku tbody').html("");

                // Isi tabel
                $.each(bahanBaku, function (key, item) {
                    $('#tabel_bahan_baku tbody').append('<tr><td>'+(no++)+'</td><td>'+item['nama']+'</td><td>'+item['jumlah']+' '+item['satuan']+'</td><td><button type="button" class="btn btn-sm btn-danger delete-bahan" data-id="'+key+'"><i class="fe fe-trash-2"></i></button></td></tr>')
                });

                // Tampilkan pada tabel
                $('.harga_beli').val(formatRupiah(parseInt(bahanBaku['total'])));
            }

            // Hapus bahan baku dari array
            function hapusBahanBaku(id){
                var harga = (bahanBaku[id]['harga'] * bahanBaku[id]['jumlah']);
                bahanBaku.splice(id, 1);
                bahanBaku['total'] = bahanBaku['total'] - harga;
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

        });
    </script>
    @endpush
</x-app-layout>
