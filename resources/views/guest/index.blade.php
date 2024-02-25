<x-guest-layout title="Home">

    @section('header')
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
            <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

            <div class="carousel-item active">
                <div class="carousel-container">
                <h2 class="animate__animated animate__fadeInDown">Welcome to <span>{{ getJudul() }}</span></h2>
                <p class="animate__animated fanimate__adeInUp">{{ getDeskripsi() }}</p>
                </div>
            </div>
        </section>
    @endsection

    <!-- ======= Produk Section ======= -->
    <section id="team" class="team">
        <div class="container">
            <div class="section-title" data-aos="zoom-out">
                <h2>Produk</h2>
                <p>Produk kami</p>
            </div>

            <div class="row">
                @foreach ($produk as $item)
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                    <div class="member" data-aos="fade-up">
                        <div class="member-img">
                            <img src="{{ asset('produk_photo/'.$item->foto) }}" class="img-fluid" alt="{{ $item->foto }}" />
                        </div>
                        <div class="member-info">
                            <h4>{{ $item->nama }}</h4>
                            <span>{{ $item->deskripsi }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5 text-center" data-aos="fade-up">
                <a href="{{ route('guest.pesan') }}" class="btn btn-primary">Jelajahi Produk</a>
            </div>
        </div>
    </section>
    <!-- End Produk Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title" data-aos="zoom-out">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div>

            <div class="mt-5 row">
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>{{ getAlamatPerusahaan() }}</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p class="mb-2">{{ getEmailPerusahaan(1) }}</p>
                            <p>{{ getEmailPerusahaan(2) }}</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p class="mb-2">{{ getNoTelp(1) }}</p>
                            <p>{{ getNoTelp(2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 col-lg-8 mt-lg-0" data-aos="fade-left">
                    <form action="{{ route('guest.sendEmail') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <x-input-label for="nama" value="Nama Lengkap" class="mb-2" />
                                <x-text-input for="nama" type="text" name="nama" required id="nama"/>
                                <x-input-error record="nama" />
                            </div>
                            <div class="mt-3 col-md-6 form-group mt-md-0">
                                <x-input-label for="email" value="Email" class="mb-2" />
                                <x-text-input for="email" type="email" name="email" id="email" required />
                                <x-input-error record="email" />
                            </div>
                        </div>
                        <div class="mt-3 form-group">
                            <x-input-label for="tentang" value="Tentang" class="mb-2" />
                            <x-text-input for="tentang" type="text" name="tentang" id="tentang" required />
                            <x-input-error record="tentang" />
                        </div>
                        <div class="mt-3 form-group">
                            <x-input-label for="pesan" value="Pesan" class="mb-2" />
                            <textarea name="pesan" rows="10" class="form-control" id="pesan" required></textarea>
                            <x-input-error record="pesan" />
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-primary" id="sendEmail">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('script')
    <script>
        $("#sendEmail").on("click", function () {
            if ($("#nama").val() != "" && $("#email").val() != "" && $("#tentang").val() != "" && $("#pesan").val() != "") {
                Swal.fire({
                    title: "Proses",
                    text: "Mohon tunggu sebentar...",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    icon: "warning",
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>
