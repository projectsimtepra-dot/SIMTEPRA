<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghapus tabel profiles yang sudah tidak digunakan.
     */
    public function up(): void
    {
        Schema::dropIfExists('profiles');
    }

    /**
     * Tidak membuat kembali tabel profiles.
     */
    public function down(): void
    {
        //
    }
};