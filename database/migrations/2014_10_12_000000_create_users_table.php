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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('level_user',['admin_devisi','kepala_arsip','direktur','pegawai']);
            $table->enum('status',['Aktif','Non-Aktif'])->default('Aktif');
            $table->string('no_ktp')->nullable(); // Kolom untuk nomor KTP
            $table->string('phone')->nullable(); // Kolom untuk nomor KTP
            $table->text('alamat')->nullable(); // Kolom untuk alamat
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
