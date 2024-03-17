<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks', 'id')->cascadeOnDelete();
            $table->timestamp('time_start');
            $table->timestamp('time_finish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_times');
    }
};
