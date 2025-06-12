<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Supabase\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;


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

        $task = new Task($validated);
        $task->user_id = Auth::user()->supabase_id;

        if ($request->hasFile('task_image')) {
            $file = $request->file('task_image');
            $fileName = Str::uuid() . '_' . time() . '.' . $file->getClientOriginalExtension();

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

        $task->save();

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
