<x-app-layout>
    <h1>Task Details</h1>

    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Start Date:</strong> {{ $task->start_date }}</p>
    <p><strong>End Date:</strong> {{ $task->end_date }}</p>
</x-app-layout>
