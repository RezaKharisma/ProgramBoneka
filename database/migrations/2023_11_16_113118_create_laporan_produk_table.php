<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->char('kode_produk');
            $table->boolean('is_deleted')->default(0);
            $table->string('keterangan');
            $table->bigInteger('jumlah')->nullable();
            $table->decimal('harga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_produk');
    }
};
