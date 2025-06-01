<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Supabase\Storage\StorageClient;


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

    $user = Auth::user();
    if (!$user) {
        Log::warning('User not logged in when trying to add task');
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $request->validate([
        'task_name' => 'required|string',
        'task_description' => 'nullable|string',
        'task_image' => 'nullable|image|max:2048', // Max 2MB
    ]);

    $imageUrl = null;
    $file = $request->file('task_image');

    if ($file) {
        Log::info('Image uploaded with original name: ' . $file->getClientOriginalName());

        $bucket = env('SUPABASE_BUCKET', 'tasks');
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_SERVICE_ROLE');

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
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Error uploading image.');
        }
    }

    try {
        $task = Task::create([
            'user_id' => $user->supabase_id,
            'task_name' => $request->task_name,
            'priority' => $request->priority,
            'task_deadline' => $request->task_deadline,
            'task_description' => $request->task_description,
            'category' => $request->categories,
            'image_url' => $imageUrl,
        ]);
        Log::info('Task created with ID: ' . $task->id);
    } catch (\Exception $e) {
        Log::error('Error creating task: ' . $e->getMessage(), ['exception' => $e]);
        return back()->with('error', 'Failed to create task.');
    }

    return redirect()->route('tasks.create')->with('success', 'Task created successfully!');
}


}

