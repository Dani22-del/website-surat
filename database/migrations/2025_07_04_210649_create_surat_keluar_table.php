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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->bigIncrements('id_surat_keluar');
            $table->integer('user_id');
            $table->string('nomor_surat'); // VARCHAR
            $table->integer('jenis_surat_id'); 
            $table->date('tanggal_surat')->nullable();
            $table->string('perihal');
            $table->text('isi');
            $table->string('tujuan');
            $table->string('lampiran')->nullable(); // opsi bisa ko
            $table->enum('status_divisi', ['Pending', 'Revisi', 'Approved'])->default('Pending');
            $table->enum('status_arsip',  ['Pending', 'Revisi', 'Approved'])->default('Pending');
            $table->enum('status_direktur', ['Pending', 'Rejected', 'Approved'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
