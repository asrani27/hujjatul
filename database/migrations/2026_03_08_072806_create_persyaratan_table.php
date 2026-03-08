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
        Schema::create('persyaratans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained()->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->text('keterangan')->nullable();
            $table->string('tipe_file')->nullable()->comment('Contoh: pdf,jpg,png');
            $table->integer('max_size')->nullable()->comment('Ukuran maksimum dalam KB');
            $table->boolean('wajib')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            
            // Add indexes for better query performance
            $table->index('layanan_id');
            $table->index('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratans');
    }
};