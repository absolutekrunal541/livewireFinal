<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Task;
use App\Models\User;

class TaskManager extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $assigned_to;
    public $status = 'pending';

    // ✅ Load tasks and users directly in the component
    public function getTasksProperty()
    {
        return Task::all();
    }

    public function getUsersProperty()
    {
        return User::all();
    }

    // ✅ Create Task Method
    public function createTask()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'assigned_to' => $this->assigned_to,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Task created successfully!');

        // ✅ Reset form after submission
        $this->reset();

        // ✅ Auto-refresh the list (because it's a computed property)
    }

    // ✅ Update Status Method
    public function updateStatus($taskId, $status)
    {
        $task = Task::findOrFail($taskId);
        $task->status = $status;
        $task->save();

        $this->dispatch('taskUpdated');
    }
    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        // Reload the tasks
        $this->tasks = Task::with('user')->get();
    }
    public function render()
    {
        return view('livewire.task-manager');
    }
}
