<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tabel_data_penyulangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penyulang')->constrained('penyulangs')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('amp_siang');
            $table->double('teg_siang');
            $table->double('mw_siang');
            $table->double('persen_siang');
            $table->integer('amp_malam');
            $table->double('teg_malam');
            $table->double('mw_malam');
            $table->double('persen_malam');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_penyulangs');
    }
};
