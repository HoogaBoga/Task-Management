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

            // Get the file content and ensure it's properly encoded
            $fileContent = file_get_contents($file->getRealPath());
            if ($fileContent === false) {
                return redirect()->back()->with('error', 'Failed to read image file.');
            }

            // Upload to Supabase storage using HTTP client
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.supabase.service_role_key'),
                    'Content-Type' => $file->getMimeType(),
                ])->withBody($fileContent, $file->getMimeType())
                  ->put(
                    config('services.supabase.url') . '/storage/v1/object/task-images/tasks/' . $fileName
                );

                if ($response->successful()) {
                    // Set the image URL to the Supabase public URL
                    $task->image_url = config('services.supabase.url') . '/storage/v1/object/public/task-images/tasks/' . $fileName;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload image to storage.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error uploading image: ' . $e->getMessage());
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
            'categories' => 'nullable|string',
        ]);

        // Convert categories string to array and clean it
        if (isset($validated['categories'])) {
            $categories = array_filter(array_map('trim', explode(',', $validated['categories'])));
            $validated['category'] = $categories;
            unset($validated['categories']);
        } else {
            $validated['category'] = [];
        }

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
