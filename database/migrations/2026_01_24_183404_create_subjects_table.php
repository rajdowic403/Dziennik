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
       Schema::create('subjects', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // np. Programowanie Obiektowe
    $table->string('code')->unique(); // np. CS-102
    $table->integer('ects')->default(5);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
