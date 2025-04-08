<?php

namespace App\Livewire\Task;

use App\Models\User;
use Livewire\Component;
use App\Jobs\AssignTaskJob;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTaskAssignedEmailJob;
use App\Http\Requests\StoreTaskRequest;

class CreateTask extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $assigned_to;
    public $file;

    public function save()
    {
        $this->validate((new StoreTaskRequest())->rules());

        $filePath = $this->file ? $this->file->store('tasks', 'public') : null;

        $taskData = [
            'title' => $this->title,
            'description' => $this->description,
            'assigned_to' => $this->assigned_to,
            'file' => $filePath,
            'status' => 'pending',
            'created_by' => Auth::id(),
        ];

        AssignTaskJob::dispatch($taskData);

        $user = User::find($this->assigned_to);
        SendTaskAssignedEmailJob::dispatch($user, (object)$taskData)->delay(now()->addSeconds(5));

        $this->reset(['title', 'description', 'assigned_to', 'file']);
        $this->emit('taskCreated');
        session()->flash('success', 'Task assigned and email sent.');
    }

    public function render()
    {
        return view('livewire.tasks.create-task', [
            'users' => User::where('role', 'employee')->get()
        ]);
    }
}
