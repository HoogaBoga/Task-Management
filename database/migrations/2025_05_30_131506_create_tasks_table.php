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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Let Laravel handle UUID in the model
            $table->uuid('user_id');
            $table->string('task_name');
            $table->dateTime('task_deadline')->nullable();
            $table->text('task_description')->nullable();
            $table->string('category')->nullable();
            $table->enum('priority', ['low', 'high'])->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
