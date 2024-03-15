<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnUpdate();
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaan')->cascadeOnUpdate();
            $table->string('periode');
            $table->string('posisi');
            $table->foreignId('dosen_id')->nullable()->constrained('dosen')->cascadeOnUpdate();
            $table->foreignId('laporan_id')->nullable()->constrained('laporan')->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
