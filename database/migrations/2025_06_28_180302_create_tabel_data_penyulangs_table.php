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
            $table->date('tanggal');
            $table->double('amp_siang');
            $table->string('teg_siang');
            $table->string('mw_siang');
            $table->string('persen_siang');
            $table->string('amp_malam');
            $table->string('teg_malam');
            $table->string('mw_malam');
            $table->string('persen_malam');
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
