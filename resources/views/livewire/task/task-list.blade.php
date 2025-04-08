<div>
    <h2 class="text-xl font-bold mb-2">Tasks</h2>

    @foreach ($tasks as $task)
    <div class="p-2 border mb-1 rounded">
        <strong>{{ $task->title }}</strong> — {{ $task->status }}
    </div>
    @endforeach
</div>