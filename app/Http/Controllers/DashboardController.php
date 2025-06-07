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

        // 2. Group tasks by status (using your original method for consistency)
        $tasksByStatus = [
            'todo' => $tasks->where('status', 'todo'),
            'in_progress' => $tasks->where('status', 'in_progress'),
            'completed' => $tasks->where('status', 'completed'),
        ];

        // 3. Get all unique categories from the user's tasks. This logic is still correct.
        $allCategories = $tasks->pluck('category')
            ->whereNotNull()
            ->flatMap(function ($categoryString) {
                return explode(',', $categoryString);
            })
            ->map(function ($category) {
                return trim($category);
            })
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        // 4. Pass BOTH tasks and categories to the view.
        return view('dashboard', [
            'tasksByStatus' => $tasksByStatus,
            'categories' => $allCategories,
        ]);
    }
}
