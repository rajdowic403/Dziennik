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
        Schema::create('lessons', function (Blueprint $table) {
    $table->id();
    $table->string('subject_name'); // np. Matematyka
    $table->foreignId('teacher_id')->constrained('users');
    $table->foreignId('classroom_id'); // opcjonalnie: sala
    $table->dateTime('start');
    $table->dateTime('end');
    $table->boolean('is_cancelled')->default(false); // Tu nauczyciel będzie "odwoływał"
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
