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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nomor', 255)->unique()->nullable();
            $table->boolean('status_peminjaman')->nullable()->default(null);
            $table->text('catatan_peminjaman')->nullable();
            $table->string('perihal_peminjaman', 255)->nullable();
            $table->dateTime('tanggal_peminjaman')->nullable();
            $table->dateTime('tanggal_kembali')->nullable();
            $table->boolean('tandatangan_pimpinan')->nullable();
            $table->string('penyelenggara', 50)->nullable();
            $table->string('acara', 50)->nullable();
            $table->string('prodi', 255)->nullable();
            $table->string('nama_peminjam', 50)->nullable();
            $table->string('nim', 15)->nullable();
            $table->string('nama_kegiatan', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
