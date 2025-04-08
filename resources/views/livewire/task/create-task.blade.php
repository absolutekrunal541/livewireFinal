<div class="p-4 bg-white rounded shadow">
    <form wire:submit.prevent="save">
        <div class="mb-2">
            <input type="text" wire:model="title" placeholder="Task Title" class="w-full border rounded p-2">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-2">
            <textarea wire:model="description" placeholder="Description" class="w-full border rounded p-2"></textarea>
        </div>

        <div class="mb-2">
            <select wire:model="assigned_to" class="w-full border rounded p-2">
                <option value="">Select Employee</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('assigned_to') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-2">
            <input type="file" wire:model="file">
            @error('file') <span class="text-red-500">{{ $message }}</span> @enderror

            @if ($file)
            <div class="mt-2 text-sm text-green-600">Uploaded: {{ $file->getClientOriginalName() }}</div>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Task</button>
    </form>
</div>