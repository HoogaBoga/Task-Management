<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task; // Import the Task model
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Str; // Import Str for UUIDs

class CheckTaskDeadlines extends Command
{
    protected $signature = 'tasks:check-deadlines';
    protected $description = 'Check for tasks with approaching deadlines and create notifications';

    public function handle()
    {
        $this->info('Checking for approaching task deadlines...');

        // Find tasks that are not complete, and are due in the next 3 days (but not past due)
        $tasks = Task::where('status', '!=', 'completed')
            ->where('task_deadline', '>', now())
            ->where('task_deadline', '<=', now()->addDays(3))
            ->get();

        foreach ($tasks as $task) {
            // Check if a notification for this specific task already exists to avoid duplicates
            $exists = DB::table('notifications')
                ->where('type', 'deadline_approaching')
                ->where('user_id', $task->user_id)
                ->whereJsonContains('data->task_id', $task->id)
                ->exists();

            if (!$exists) {
                DB::table('notifications')->insert([
                    'id' => Str::uuid(),
                    'user_id' => $task->user_id,
                    'type' => 'deadline_approaching',
                    'data' => json_encode([
                        'task_id' => $task->id,
                        'task_name' => $task->task_name,
                        'task_deadline' => $task->task_deadline,
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->info("Notification created for task: {$task->task_name}");
            }
        }

        $this->info('Done.');
        return 0;
    }
}
