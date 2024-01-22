<x-app-layout>
    <form method="post" action="{{ route('tasks.store') }}">
        @csrf
        <!-- Include input fields for task details -->
        <button type="submit">Create Task</button>
    </form>
</x-app-layout>
