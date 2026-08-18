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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_lengkap', 255);

            $table->string('nip', 30)
                ->nullable()
                ->unique();

            $table->string('no_hp', 20)
                ->nullable();

            $table->string('jabatan', 150)
                ->nullable();

            $table->string('instansi', 150)
                ->nullable();

            $table->text('alamat')
                ->nullable();

            $table->string('foto')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};