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

        // Convert categories string to array
        if (isset($validated['categories'])) {
            $validated['category'] = array_filter(explode(',', $validated['categories']));
            unset($validated['categories']);
        }

        $task = new Task($validated);
        $task->user_id = Auth::user()->supabase_id;

        if ($request->hasFile('task_image')) {
            $path = $request->file('task_image')->store('task-images', 'public');
            $task->image_url = Storage::url($path);
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

        // Convert categories string to array
        if (isset($validated['categories'])) {
            $validated['category'] = array_filter(explode(',', $validated['categories']));
            unset($validated['categories']);
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

