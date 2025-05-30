<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class AddTaskController extends Controller
{
    public function create()
    {
        return view('add-task'); // Assuming your view is named add-task.blade.php
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'task-name' => 'required|string|max:255',
            'priority' => 'required|in:high,low',
            'task-deadline' => 'required|date',
            'task-description' => 'required|string',
            'task-image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|string',
        ]);

        // Handle file upload
        $imageUrl = null;
        if ($request->hasFile('task-image')) {
            $imageUrl = $request->file('task-image')->store('task-images', 'public');
        }

        // Create the task with correct field names
        $task = Task::create([
            'task_name' => $validated['task-name'],
            'task_priority' => $validated['priority'],
            'task_deadline' => $validated['task-deadline'],
            'task_description' => $validated['task-description'],
            'category' => $validated['categories'],
            'image_url' => $imageUrl,
        ]);

        return redirect()->back()->with('success', 'Task created successfully!');
    }
}
