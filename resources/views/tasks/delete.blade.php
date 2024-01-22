<x-app-layout>
    <form method="post" action="{{ route('tasks.destroy', $task->id) }}">
        @csrf
        @method('delete')
        <p>Are you sure you want to delete this task?</p>
        <button type="submit">Yes, Delete</button>
    </form>
</x-app-layout>
