<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        Log::info('DashboardController@index called');

        if (!Auth::check()) {
            Log::warning('User not authenticated.');
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // 1. Start building the query for tasks
        $tasksQuery = Task::where('user_id', $user->supabase_id);

        // 2. Apply search filter if provided
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');
            // Search in both task_name and task_description
            $tasksQuery->where(function ($query) use ($searchTerm) {
                $query->where('task_name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('task_description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // 3. Apply category filter if provided
        if ($request->has('category') && $request->input('category') != '') {
            $category = $request->input('category');
            // Use whereJsonContains for columns storing JSON arrays
            $tasksQuery->whereJsonContains('category', $category);
        }

        // 4. Execute the query
        $tasks = $tasksQuery->orderBy('created_at', 'desc')->get();

        // Ensure categories are properly handled
        $tasks->each(function ($task) {
            if (is_string($task->category)) {
                $task->category = json_decode($task->category, true) ?? [];
            }
        });

        $tasksByStatus = [
            'todo' => $tasks->where('status', 'todo')->values(),
            'in_progress' => $tasks->where('status', 'in_progress')->values(),
            'completed' => $tasks->where('status', 'completed')->values(),
        ];

        // 5. Check if the request is an AJAX request (wants JSON)
        if ($request->wantsJson()) {
            // If yes, just return the filtered task data as JSON
            return response()->json($tasksByStatus);
        }

        // --- For initial page load ONLY ---

        // Get all unique categories from ALL user tasks (for the filter dropdown)
        $allUserTasks = Task::where('user_id', $user->supabase_id)->get();
        $allCategories = $allUserTasks->pluck('category')
            ->whereNotNull()
            ->flatten()
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        // If it's a normal browser request, return the full view
        return view('dashboard', [
            'tasksByStatus' => $tasksByStatus,
            'categories' => $allCategories, // Pass all categories for the filter dropdown
        ]);
    }
}
