<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; // Still needed for gen_random_uuid()
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // REMOVE OR COMMENT OUT the DB::statement for CREATE TYPE task_priority
        // DB::statement("CREATE TYPE task_priority AS ENUM ('low', 'high');");

        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('user_id');
            $table->foreign('user_id')->references('supabase_id')->on('users')->onDelete('cascade');

            $table->text('task_name');
            $table->timestampTz('task_deadline')->nullable();
            $table->text('task_description')->nullable();
            $table->text('category')->nullable();

            // Use Laravel's enum method for the priority column
            $table->enum('priority', ['low', 'high'])->nullable(); // <-- CORRECTED LINE FOR PRIORITY

            $table->string('image_url')->nullable();
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
        // REMOVE OR COMMENT OUT the DB::statement for DROP TYPE task_priority
        // DB::statement("DROP TYPE IF EXISTS task_priority;");
    }
};
