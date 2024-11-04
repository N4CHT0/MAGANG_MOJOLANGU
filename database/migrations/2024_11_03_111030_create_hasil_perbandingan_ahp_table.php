<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilPerbandinganAhpTable extends Migration
{
    public function up()
    {
        Schema::create('hasil_perbandingan_ahp', function (Blueprint $table) {
            $table->id();
            $table->json('data_perbandingan'); // Kolom JSON untuk menyimpan semua data perhitungan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_perbandingan_ahp');
    }
}
