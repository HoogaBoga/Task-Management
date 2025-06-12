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
    Schema::create('notifications', function (Blueprint $table) {
        $table->uuid('id')->primary(); // A unique ID for the notification itself
        $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
        $table->string('type'); // e.g., 'deadline_approaching'
        $table->json('data'); // To store info like the task name, task id, etc.
        $table->timestamp('read_at')->nullable(); // To know if the user has seen it
        $table->timestamps(); // created_at and updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
