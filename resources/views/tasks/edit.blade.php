<x-app-layout>
    <form method="post" action="{{ route('tasks.update', $task->id) }}">
        @csrf
        @method('put')
        <!-- Include input fields pre-filled with task details -->
        <button type="submit">Update Task</button>
    </form>
</x-app-layout>
