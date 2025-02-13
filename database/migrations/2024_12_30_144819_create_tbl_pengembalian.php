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
        Schema::create('tbl_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_member');
            $table->unsignedBigInteger('id_denda');
            $table->unsignedBigInteger('id_buku');
            $table->date('tanggal_pengembalian');
            $table->string('status', 20);
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id')->on('tbl_member')->onDelete('cascade');
            $table->foreign('id_member')->references('id')->on('tbl_member')->onDelete('cascade');
            $table->foreign('id_buku')->references('id')->on('tbl_buku')->onDelete('cascade');
            $table->foreign('id_denda')->references('id')->on('tbl_buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pengembalian');
    }
};
