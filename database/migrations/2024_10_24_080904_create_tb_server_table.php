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
        if (Schema::hasTable('tb_server')) {
            Schema::drop('tb_server');
        }
        Schema::create('tb_server', function (Blueprint $table) {
            $table->id();
            $table->string('id_server');
            $table->string('server');
            $table->string('alamat_server');
            $table->string('user');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_server');
    }
};
