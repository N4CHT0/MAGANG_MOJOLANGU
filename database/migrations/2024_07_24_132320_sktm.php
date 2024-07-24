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
        Schema::create('sktm', function (Blueprint $table) {
            $table->id();
            $table->string('id_users');
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->string('rt');
            $table->string('rw');
            $table->string('nik');
            $table->string('foto_ktp');
            $table->string('foto_kk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sktm');
    }
};
