<?php

use Illuminate\Database\Migrations\Migration; // Mengimpor kelas Migration
use Illuminate\Database\Schema\Blueprint; // Mengimpor kelas Blueprint
use Illuminate\Support\Facades\Schema; // Mengimpor kelas Schema

return new class extends Migration // Mendefinisikan migrasi
{
    public function up(): void // Menjalankan migrasi
    {
        Schema::create('items', function (Blueprint $table) { // Membuat tabel 'items'
            $table->id(); // Membuat kolom 'id'
            $table->string('name'); // Membuat kolom 'name'
            $table->text('description'); // Membuat kolom 'description'
            $table->timestamps(); // Membuat kolom 'created_at' dan 'updated_at'
        });
    }

    public function down(): void // Membatalkan migrasi
    {
        Schema::dropIfExists('items'); // Menghapus tabel 'items' jika ada
    }
};
