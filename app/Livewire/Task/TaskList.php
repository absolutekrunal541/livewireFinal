<?php

namespace App\Livewire\Task;

use Livewire\Component;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskList extends Component
{
    public $tasks = [];

    protected $listeners = ['taskCreated' => 'refreshList'];

    protected $taskRepo;

    public function boot(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function mount()
    {
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->tasks = $this->taskRepo->getAll();
    }

    public function render()
    {
        return view('livewire.tasks.task-list');
    }
}
