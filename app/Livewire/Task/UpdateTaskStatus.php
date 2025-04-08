<?php

namespace App\Livewire\Task;

use Livewire\Component;
use App\Models\Task;

class UpdateTaskStatus extends Component
{
    public $taskId, $status;

    public function mount($taskId, $status)
    {
        $this->taskId = $taskId;
        $this->status = $status;
    }

    public function updateStatus()
    {
        $task = Task::findOrFail($this->taskId);
        $task->status = $this->status;
        $task->save();

        $this->emit('taskUpdated');
    }

    public function render()
    {
        return view('livewire.tasks.update-task-status');
    }
}
