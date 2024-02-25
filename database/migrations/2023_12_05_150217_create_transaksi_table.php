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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->char('invoice');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_customer');
            $table->string('no_telp');
            $table->string('email');
            $table->text('alamat');
            $table->text('deskripsi')->default('');
            $table->decimal('total');
            $table->enum('status',['Pending', 'Pembayaran', 'Proses', 'Selesai', 'Batal'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
