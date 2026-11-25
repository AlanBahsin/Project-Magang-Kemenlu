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
        Schema::create('kredensials', function (Blueprint $table) {
    $table->id();
    $table->string('negara');
    $table->string('username');
    $table->string('password');
    $table->string('submitted_by')->nullable();
    $table->enum('status', ['pending','approved','rejected'])->default('pending');
    $table->date('tanggal')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kredensials');
    }
};
