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
            $table->string('nomor', 255)->unique();
            $table->boolean('status_peminjaman');
            $table->text('catatan_peminjaman')->nullable();
            $table->string('perihal_peminjaman', 255);
            $table->dateTime('tanggal_peminjaman');
            $table->dateTime('tanggal_kembali');
            $table->boolean('tandatangan_pimpinan')->nullable();
            $table->string('penyelenggara', 50);
            $table->string('acara', 50);
            $table->string('prodi', 255);
            $table->string('nama_peminjam', 50);
            $table->string('nim', 15);
            $table->string('nama_kegiatan', 50);
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
