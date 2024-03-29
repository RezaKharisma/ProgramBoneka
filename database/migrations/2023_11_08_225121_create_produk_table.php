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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->json('bahan_baku');
            $table->decimal('harga_beli');
            $table->decimal('harga_jual');
            $table->integer('stok')->default(0);
            $table->enum('status',['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->string('foto')->default('default.png')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
