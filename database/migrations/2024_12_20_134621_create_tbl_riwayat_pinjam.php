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
        Schema::create('tbl_riwayat_pinjam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_peminjaman'); // Relasi ke peminjaman buku
            $table->unsignedBigInteger('id_buku');       // Relasi ke buku
            $table->enum('status', ['Dipinjam', 'Dikembalikan']);
            $table->date('tanggal_kembali');
            $table->integer('denda')->default(0);        // Kolom untuk menyimpan denda
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_peminjaman')->references('id')->on('tbl_peminjaman_buku')->onDelete('cascade');
            $table->foreign('id_buku')->references('id')->on('tbl_buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_riwayat_pinjam');
    }
};
