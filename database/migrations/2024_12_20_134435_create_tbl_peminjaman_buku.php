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
            Schema::create('tbl_peminjaman_buku', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_member'); // Relasi ke member
                $table->date('tanggal_kembali');        // Tanggal pengembalian
                $table->timestamps();

                // Foreign key untuk id_member
                $table->foreign('id_member')->references('id')->on('tbl_member')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('tbl_peminjaman_buku');
        }
    };
