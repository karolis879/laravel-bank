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
    Schema::create('accounts', function (Blueprint $table) {
        $table->id();
        $table->string('iban', 20);
        $table->integer('balance'); // Remove auto_increment
        $table->unsignedBigInteger('holder_id');
        $table->foreign('holder_id')->references('id')->on('holders');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
