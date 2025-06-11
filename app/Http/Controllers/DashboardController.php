<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        Log::info('DashboardController@index called');

        if (!Auth::check()) {
            Log::warning('User not authenticated.');
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // 1. Fetch tasks using the CORRECT key: $user->supabase_id
        $tasks = Task::where('user_id', $user->supabase_id)->get();

        // Ensure categories are properly handled
        $tasks->each(function ($task) {
            if (is_string($task->category)) {
                $task->category = json_decode($task->category, true) ?? [];
            }
        });

        $tasksByStatus = $tasks->groupBy('status');

        // 2. Get all unique categories from tasks
        $allCategories = $tasks->pluck('category')
            ->filter()
            ->flatMap(function ($categories) {
                return is_array($categories) ? $categories : [];
            })
            ->unique()
            ->values()
            ->toArray();

        // 4. Pass BOTH tasks and categories to the view.
        return view('dashboard', [
            'tasksByStatus' => $tasksByStatus,
            'categories' => $allCategories,
        ]);
    }
}
