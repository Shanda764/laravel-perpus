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
        Schema::create('tbl_member', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_member', 20)->unique();
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('no_telepon', 15);
            $table->string('email', 100)->nullable()->unique();
            $table->date('tanggal_daftar');
            $table->string('status');
            $table->string('gambar')->nullable();
            $table->string('nis', 20)->nullable();
            $table->string('nip', 18)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_member');
    }
};

