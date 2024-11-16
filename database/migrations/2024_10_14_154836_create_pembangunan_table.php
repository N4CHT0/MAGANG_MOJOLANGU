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
        Schema::create('pembangunan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->longText('deskripsi');
            $table->longText('id_users');
            $table->string('pengusul');
            $table->date('tanggal_pengajuan');
            $table->string('status');
            $table->string('kategori');
            $table->float('biaya');
            $table->string('lokasi');
            $table->date('waktu_pelaksanaan');
            $table->float('prioritas');
            $table->string('dokumentasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembangunan');
    }
};
