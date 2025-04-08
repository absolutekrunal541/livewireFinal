<p>Hello {{ $task->assignedTo->name }},</p>
<p>A new task "<strong>{{ $task->title }}</strong>" has been assigned to you.</p>
<p>Status: {{ $task->status }}</p>
