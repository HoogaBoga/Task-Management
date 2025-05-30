<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // for UUID generation
use Supabase\Storage\StorageClient;

class AddTaskController extends Controller
{
    public function create()
    {
        return view('add-task');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            // User not logged in - redirect to login or show error
            return redirect()->route('login')->withErrors('Please login first.');
        }

        $validated = $request->validate([
            'task-name' => 'required|string|max:255',
            'priority' => 'required|in:high,low',
            'task-deadline' => 'required|date',
            'task-description' => 'required|string',
            'task_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|string',
        ]);

        $imageUrl = null;
        if ($request->hasFile('task_image')) {
            $file = $request->file('task_image');
            $sanitizedOriginalName = preg_replace('/[^A-Za-z0-9_.\-]/', '', $file->getClientOriginalName());
            $fileName = 'tasks/' . time() . '_' . $sanitizedOriginalName;
            $fileContent = file_get_contents($file->getRealPath());
            $fileMimeType = $file->getMimeType();

            $supabaseApiKey = env('SUPABASE_KEY');
            $supabaseReferenceId = env('SUPABASE_REFERENCE_ID');

            if (!$supabaseApiKey || !$supabaseReferenceId) {
                Log::error('Supabase API Key or Reference ID is not configured in .env');
            } else {
                try {
                    $storageClient = new StorageClient($supabaseApiKey, $supabaseReferenceId);
                    $bucketName = 'task-images';
                    $filePath = $fileName;

                    $storageClient->upload(
                        $bucketName,
                        $filePath,
                        $fileContent,
                        ['content-type' => $fileMimeType]
                    );

                    $imageUrl = $storageClient->getPublicUrl($bucketName, $filePath);
                } catch (\Exception $e) {
                    Log::error('Supabase storage error in AddTaskController: ' . $e->getMessage());
                }
            }
        }

        Task::create([
            'id' => (string) Str::uuid(), // generate UUID for task id
            'user_id'          => Auth::user()->supabase_id, // <-- Use UUID here
            'task_name' => $validated['task-name'],
            'priority' => $validated['priority'],
            'task_deadline' => $validated['task-deadline'],
            'task_description' => $validated['task-description'],
            'category' => $validated['categories'] ?? null,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('tasks.create')->with('success', 'Task created successfully!');
    }
}
