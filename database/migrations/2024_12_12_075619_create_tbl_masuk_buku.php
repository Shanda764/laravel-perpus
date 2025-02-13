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
        Schema::create('tbl_masuk_buku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buku_id');
            $table->integer('jumlah');
            $table->string('keterangan', 100);
            $table->date('tanggal_masuk');
            $table->timestamps();

            $table->foreign('buku_id')->references('id')->on('tbl_buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_masuk_buku');
    }
};
