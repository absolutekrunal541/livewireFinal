<div class="grid grid-cols-10 gap-6 bg-white shadow-lg rounded-xl p-6">
    @can('create-task')
    {{-- ✅ Left Column - Task Form --}}
    <div class="col-span-3 space-y-6">
        <h2 class="text-lg font-semibold text-gray-800">Create Task</h2>

        <form wire:submit.prevent="createTask" class="space-y-4">
            {{-- ✅ Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" wire:model="title" id="title"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('title') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- ✅ Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('description') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- ✅ Assign To --}}
            <div>
                <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assign To</label>
                <select wire:model="assigned_to" id="assigned_to"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select User</option>
                    @foreach ($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('assigned_to') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- ✅ Submit Button --}}
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition">
                Create Task
            </button>
        </form>
    </div>
    @endcan
    {{-- ✅ Right Column - Task List --}}
    <div class="col-span-7 space-y-6">
        <h2 class="text-lg font-semibold text-gray-800">Task List</h2>

        @if ($this->tasks->isEmpty())
            <p class="text-gray-500">No tasks available.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Update Status</th>
                            @can('delete-task')
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($this->tasks as $task)
                            <tr class="hover:bg-gray-50">
                                {{-- ✅ Title --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                    {{ $task->title }}
                                   
                                </td>
                                <td>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $task->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                                </td>

                                {{-- ✅ Assigned To --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $task->assigned_to ? $task->user->name : 'Unassigned' }}
                                </td>

                                {{-- ✅ Status Dropdown --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @can('edit-task')
                                    <select wire:change="updateStatus({{ $task->id }}, $event.target.value)"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in-progress" {{ $task->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @else
                                    {{ ucfirst($task->status) }}
                                @endcan
                                </td>

                                {{-- ✅ Actions --}}
                                @can('delete-task')
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button wire:click="deleteTask({{ $task->id }})"
                                        class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out">
                                        ❌
                                    </button>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
