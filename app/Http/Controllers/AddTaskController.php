<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class AddTaskController extends Controller
{
    // Show the upload form
    public function create()
    {
        return view('add-task'); // Make sure resources/views/add-task.blade.php exists
    }

    // Handle the form submission and upload the file to Supabase
    public function store(Request $request)
    {
        Log::info('AddTaskController@store called');
        Log::info('Request data:', $request->all()); // Debug: Log all request data

        $user = Auth::user();
        if (!$user) {
            Log::warning('User not logged in when trying to add task');
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        Log::info('User authenticated:', ['user_id' => $user->id, 'supabase_id' => $user->supabase_id]);

        // Validate the request
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_deadline' => 'nullable|date',
            'priority' => 'required|in:low,high',
            'status' => 'nullable|in:todo,in_progress,completed',
            'categories' => 'nullable|string|max:255', // Fixed: was 'category' in validation but 'categories' in form
            'task_image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        Log::info('Validation passed:', $validated);

        $imageUrl = null;
        $file = $request->file('task_image');

        if ($file) {
            Log::info('Image uploaded with original name: ' . $file->getClientOriginalName());

            $bucket = env('SUPABASE_BUCKET', 'tasks');
            $supabaseUrl = env('SUPABASE_URL');
            $supabaseKey = env('SUPABASE_SERVICE_ROLE');

            // Check if Supabase credentials are set
            if (!$supabaseUrl || !$supabaseKey) {
                Log::error('Supabase credentials missing', [
                    'supabase_url' => $supabaseUrl ? 'set' : 'missing',
                    'supabase_key' => $supabaseKey ? 'set' : 'missing'
                ]);
                return back()->with('error', 'Supabase configuration error.');
            }

            // Fixed: Use getClientOriginalExtension() instead of Str::slug()
            $fileName = 'tasks/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            try {
                $uploadResponse = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey,
                ])->attach(
                    'file', file_get_contents($file), $fileName, [
                        'Content-Type' => $file->getMimeType(),
                    ]
                )->post("$supabaseUrl/storage/v1/object/$bucket/$fileName");

                Log::info('Supabase upload response:', [
                    'status' => $uploadResponse->status(),
                    'body' => $uploadResponse->body()
                ]);

                if ($uploadResponse->failed()) {
                    Log::error('Failed to upload task image to Supabase.', [
                        'status' => $uploadResponse->status(),
                        'response' => $uploadResponse->body(),
                    ]);
                    return back()->with('error', 'Failed to upload task image.');
                }

                $imageUrl = "$supabaseUrl/storage/v1/object/public/$bucket/$fileName";
                Log::info('Image uploaded successfully. Public URL: ' . $imageUrl);

            } catch (\Exception $e) {
                Log::error('Exception while uploading image', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->with('error', 'Error uploading image: ' . $e->getMessage());
            }
        }

        try {
            Log::info('Creating task with data:', [
                'user_id' => $user->supabase_id,
                'task_name' => $request->task_name,
                'priority' => $request->priority,
                'task_deadline' => $request->task_deadline,
                'task_description' => $request->task_description,
                'category' => $request->categories, // Fixed: use 'categories' from form
                'image_url' => $imageUrl,
                'status' => $request->input('status', 'todo'),
            ]);

            // Handle categories - convert to array if it's a string
            $categories = $request->categories;
            if (is_string($categories)) {
                // If it's comma-separated string, convert to array
                $categories = array_map('trim', explode(',', $categories));
            } elseif (is_null($categories)) {
                $categories = [];
            }

            $task = Task::create([
                'user_id' => $user->supabase_id,
                'task_name' => $request->task_name,
                'priority' => $request->priority,
                'task_deadline' => $request->task_deadline,
                'task_description' => $request->task_description,
                'category' => $categories, // Now properly formatted as array for JSON
                'image_url' => $imageUrl,
                'status' => $request->input('status', 'todo'),
            ]);

            Log::info('Task created successfully with ID: ' . $task->id);

        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to create task: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        // Authorization: Ensure the user owns the task
        if ($task->user_id !== Auth::user()->supabase_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validation
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_deadline' => 'nullable|date',
            'priority' => 'required|in:low,high',
            'status' => 'required|in:todo,in_progress,completed',
            'category' => 'nullable|string|max:255',
        ]);

        // Update the task with validated data
        $task->update($validated);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        // Authorization: Ensure the user owns the task
        if ($task->user_id !== Auth::user()->supabase_id) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }
}
