<div>
    <select wire:model="status" wire:change="updateStatus" class="border p-1 rounded">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
    </select>
</div>