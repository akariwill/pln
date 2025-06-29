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
        Schema::create('penyulangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_trafo_daya')->constrained('trafo_dayas')->onDelete('cascade');
            $table->string('nama');
            $table->integer('setting_rele');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyulangs');
    }
};
