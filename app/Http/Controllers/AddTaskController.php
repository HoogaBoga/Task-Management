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
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $request->validate([
        'task_name' => 'required|string',
        'task_description' => 'nullable|string',
        'task_image' => 'file|image|max:2048',
    ]);

    $imageUrl = null; // Initialize to null in case no image uploaded or upload fails

    $file = $request->file('task_image');

    if ($file && $file->isValid()) {
        $bucket = env('SUPABASE_BUCKET');
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_SERVICE_ROLE');

        $fileName = 'tasks/' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->getRealPath();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => $file->getMimeType(),
        ])->put("$supabaseUrl/storage/v1/object/$bucket/$fileName", file_get_contents($filePath));

        if ($response->failed()) {
            return back()->with('error', 'Failed to upload image to Supabase.');
        }

        $imageUrl = "$supabaseUrl/storage/v1/object/public/$bucket/$fileName";
    }

    // Now save task with or without image URL
    $task = Task::create([
        'user_id' => $user->supabase_id,
        'task_name' => $request->task_name,
        'priority' => $request->priority,
        'task_deadline' => $request->task_deadline,
        'task_description' => $request->task_description,
        'category' => $request->category,
        'image_url' => $imageUrl,
    ]);

    return redirect()->route('tasks.create')->with('success', 'Task created successfully!');
}


}

