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
use Illuminate\Support\Facades\DB;

class AddTaskController extends Controller
{
    public function create()
    {
        return view('add-task');
    }

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

        if (isset($validated['categories'])) {
            $categories = array_filter(array_map('trim', explode(',', $validated['categories'])));
            $validated['category'] = $categories;
            unset($validated['categories']);
        } else {
            $validated['category'] = [];
        }

        $task = new Task($validated);
        $user = Auth::user();
        $task->user_id = $user->supabase_id;

        if ($request->hasFile('task_image')) {
            $file = $request->file('task_image');
            $fileName = Str::uuid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $fileContent = file_get_contents($file->getRealPath());
            if ($fileContent === false) {
                return redirect()->back()->with('error', 'Failed to read image file.');
            }

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.supabase.service_role_key'),
                    'Content-Type' => $file->getMimeType(),
                ])->withBody($fileContent, $file->getMimeType())
                  ->put(
                    config('services.supabase.url') . '/storage/v1/object/task-images/tasks/' . $fileName
                );

                if ($response->successful()) {
                    $task->image_url = config('services.supabase.url') . '/storage/v1/object/public/task-images/tasks/' . $fileName;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload image to storage.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error uploading image: ' . $e->getMessage());
            }
        }

        $task->save();

        DB::table('notifications')->insert([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'type' => 'App\Notifications\TaskCreated',
            'data' => json_encode(['message' => 'New task created: ' . $task->task_name]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::user()->supabase_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_deadline' => 'nullable|date',
            'priority' => 'required|in:low,high',
            'status' => 'required|in:todo,in_progress,completed',
            'categories' => 'nullable|string',
        ]);

        if ($request->has('categories')) {
            $categories = array_filter(array_map('trim', explode(',', $validated['categories'] ?? '')));
            $validated['category'] = $categories;
            unset($validated['categories']);
        }

        $task->update($validated);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::user()->supabase_id) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }
}
