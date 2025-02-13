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
        if (!Schema::hasTable('tbl_denda')) {
            Schema::create('tbl_denda', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_pinjam');
                $table->integer('nominal_denda')->default(1000); // Denda per hari keterlambatan
                $table->timestamps();

                $table->foreign('id_pinjam')->references('id')->on('tbl_peminjaman_buku')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_denda');
    }
};
