<x-guest-layout title="Pemesanan">
    @section('style')
        <style>
            .box-cards:hover{
                box-shadow: 0 0 50px -10px #000000;
                cursor: pointer;
            }

            .box-cards-border{
                border: 10px solid;
            }

            .box-cards-button{
                position: absolute;
                overflow: hidden;
                display: none;
            }
        </style>
    @endsection

    <section id="cta" class="cta">
    <div class="container">
        <div class="row aos-init aos-animate" data-aos="zoom-out">
        <div class="text-center">
            <h3 class="p-5">Pemesanan Produk </h3>
        </div>
        </div>
    </div>
    </section>

    <!-- ======= Produk Section ======= -->
    <section id="team" class="team">
        <div class="container">

            <div class="section-title" data-aos="zoom-out">
                <h2>Identitas</h2>
                <p>Isi form sesuai identitas pengiriman.</p>
            </div>

            <div class="col-lg-12 mt-lg-12" data-aos="fade-left" style="margin-bottom: 130px">
                <form action="{{ route('guest.savePesan') }}" method="POST" id="formPesan">
                    @csrf
                    <input type="hidden" id="inputBox" name="inputBox">
                    <div class="row">
                        <div class="col-md-4 mb-sm-4 form-group">
                            <x-input-label for="nama" value="Nama" class="mb-2"/>
                            <x-text-input for="nama" type="text" id="nama_customer" name="nama" value="{{ (old('nama') != '') ? old('nama') : ((Auth()->user()) ? Auth()->user()->name : '') }}" required placeholder="Nama Lengkap" />
                            <x-input-error record="nama" />
                        </div>
                        <div class="col-md-4 mb-sm-4 form-group">
                            <x-input-label for="email" value="Email" class="mb-2" />
                            <x-text-input for="email" type="email" id="email_customer" name="email" value="{{ (old('email') != '') ? old('email') : ((Auth()->user()) ? Auth()->user()->email : '') }}" required placeholder="Email"/>
                            <x-input-error record="email" />
                        </div>
                        <div class="col-md-4 mb-sm-1 form-group">
                            <x-input-label for="no_telp" value="Nomor Telepon" class="mb-2" />
                            <div class="mb-1 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                </div>
                                <x-text-input for="no_telp" type="number" id="no_telp_customer" name="no_telp" value="{{ (old('no_telp') != '') ? old('no_telp') : ((Auth()->user()) ? Auth()->user()->no_telp : '') }}" required />
                                <x-input-error record="no_telp" />
                            </div>
                            <span class="mt-0 help-block"><small>Input angka saja.</small></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-3 col-md-6 form-group">
                            <x-input-label for="pesan" value="Pesan" class="mb-2" />
                            <textarea name="pesan" rows="2" class="form-control" id="pesan" required placeholder="Deskripsi Pesanan">{{ old('no_telp') ?? '' }}</textarea>
                            <x-input-error record="pesan" />
                        </div>
                        <div class="mt-3 col-md-6 form-group">
                            <x-input-label for="alamat" value="Alamat" class="mb-2" />
                            <textarea name="alamat" rows="2" class="form-control" id="alamat" required placeholder="Alamat Pengiriman">{{ old('no_telp') ?? '' }}</textarea>
                            <x-input-error record="alamat" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-5 section-title" data-aos="zoom-out">
                <h2>Produk</h2>
                <p>Pilih produk yang ingin dipesan</p>
            </div>

            <div class="row" id="boxProduk">
                @foreach ($produk as $item)
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex align-items-stretch">
                    <div class="member box-cards box-{{ $item->id }}" data-aos="fade-up" id="boxCard" data-id="{{ $item->id }}" data-kode="{{ $item->kode }}" data-tersedia="@php if($item->stok == 0){echo'No';}else{ echo 'Yes';} @endphp">
                        <div class="member-img">
                            <button class="btn btn-block btn-danger box-cards-button">X</button>
                            <img src="{{ asset('produk_photo/'.$item->foto) }}" class="img-fluid" alt="{{ $item->foto }}" />
                        </div>
                        <div class="member-info">
                            <h4>{{ $item->nama }}</h4>
                            @if ($item->stok == 0)
                                <div class="mt-3 btn btn-danger btn-sm disabled w-100">Stok Habis</div>
                            @else
                                <span class="mb-2">Rp. {{ currency_IDR($item->harga_jual) }}</span>
                                <span>{{ $item->deskripsi }}</span>
                                <span>Stok : {{ $item->stok }}</span>
                                <input type="number" class="mt-2 form-control input-box" data-kode="{{ $item->kode_produk }}" data-stok="{{ $item->stok }}" style="display: none" onkeypress="return isNumberKey(event);" placeholder="Jumlah Item">
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5 text-center" data-aos="fade-up">
                <button type="button" href="{{ route('guest.pesan') }}" class="btn btn-primary btn-lg boxSubmit">Proses Pesanan</button>
            </div>
        </div>
    </section>
    <!-- End Produk Section -->

    @push('script')
        @if (!Auth::check())
            <script>
                $(document).ready(function () {
                    Swal.fire({
                        title: 'Sudah memiliki akun?',
                        text: "Diperlukan login untuk melakukan pemesanan",
                        confirmButtonColor: '#3085d6',
                        showDenyButton: true,
                        confirmButtonText: 'Nanti Saja',
                        denyButtonText: 'Belum',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire('Baiklah!', 'Pencet tombol login di sebelah kanan atas jika ingin membuat akun.', 'success')
                        } else if (result.isDenied) {
                            window.location.href = "/login";
                        }
                    })
                });
            </script>
        @endif

        <script>
            $(document).ready(function () {
                var inputBox = [];
                $("#boxProduk").on('click', '#boxCard', function(){
                    var ketersediaan = $(this).data('tersedia');
                    if (cekTersedia(ketersediaan)) {
                        var idBox = $(this).data('id');
                        $(this).addClass('box-cards-border');
                        $(this).find('button').show();
                        $(this).find('input').show();
                    }
                    event.stopPropagation();
                });

                $("#boxProduk #boxCard button.box-cards-button").click(function(){
                    $(this).parent().parent().removeClass('box-cards-border');
                    $(this).hide();
                    $(this).parent().siblings().children('input').hide();
                    $(this).parent().siblings().children('input').val('');
                    event.stopPropagation();
                });

                $(".boxSubmit").on('click', function(){
                    isValid = false;
                    inputBox = [];
                    var data = {};
                    var allInput = document.querySelectorAll(".input-box");

                    if (validationInput()) {
                        for (let index = 0; index < allInput.length; index++) {
                            data = {};
                            if (allInput[index].value != "") {
                                data['kode_produk'] = allInput[index].dataset.kode;
                                data['value'] = allInput[index].value;
                                data['stok'] = allInput[index].dataset.stok;
                                
                                if (data['value'] > data['stok']) {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Pembelian melebihi stok.',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                    isValid = false;
                                }
                                else{
                                    inputBox.push(data);
                                    isValid = true;
                                }
                            }
                        }

                        if (isValid) {
                            $("#inputBox").val(JSON.stringify(inputBox));
                            $('#formPesan').submit();
                        }
                    }else{
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Mohon periksa form kembali.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                })

                function validationInput(){
                    if ($("#nama_customer").val() != "" && $("#email_customer").val() != "" && $("#no_telp_customer").val() != "" && $("#pesan").val() != "" && $("#alamat").val() != "") {
                        return true;
                    }else{
                        return false;
                    }
                }

                function cekTersedia(ketersediaan){
                    if (ketersediaan == 'Yes') {
                        return true;
                    }else{
                        return false;
                    }
                }
            });
        </script>
    @endpush
</x-guest-layout>
