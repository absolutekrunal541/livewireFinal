<?php

namespace App\Http\Controllers;

use App\Jobs\AssignTaskJob;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a new task and assign it using a queued job.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id'     => 'required|exists:users,id'
        ]);

        // Create task
        $task = Task::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'assigned_to' => null // Not assigned yet
        ]);

        // Fetch user
        $user = User::find($validated['user_id']);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Dispatch job for task assignment
        AssignTaskJob::dispatch($task->id, $user->id)->onQueue('default');

        return response()->json([
            'message' => 'Task created and assignment job dispatched!',
            'task'    => $task
        ], 201);
    }
}
