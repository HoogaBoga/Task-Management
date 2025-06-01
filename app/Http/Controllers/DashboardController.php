<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
   public function index()
{
    Log::info('DashboardController@index called');

    Log::info('Auth helper type: ' . get_class(auth()));


    if (!Auth::check()) {
        Log::warning('User not authenticated.');
        return redirect()->route('login')->with('error', 'Please login first.');
    }

    $user = Auth::user();
    Log::info('Authenticated user', ['user' => $user]);

    try {
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_SERVICE_ROLE'),
            'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE'),
        ])->get(env('SUPABASE_URL') . '/rest/v1/tasks', [
            'select' => '*'
        ]);

        if ($response->successful()) {
            $tasks = Task::where('user_id', $user->supabase_id)->get();

            $tasksByStatus = [
                'todo' => $tasks->where('status', 'todo'),
                'in_progress' => $tasks->where('status', 'in_progress'),
                'completed' => $tasks->where('status', 'completed'),
            ];

            return view('dashboard', compact('tasksByStatus'));
        }

        Log::error('Failed to fetch tasks from Supabase', ['response' => $response->body()]);
        abort(500, 'Failed to fetch tasks from Supabase');

    } catch (\Exception $e) {
        Log::error('Dashboard error: ' . $e->getMessage());
        abort(500, 'Dashboard error');
    }
}


}
