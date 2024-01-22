<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="calendar.css">
        <title>Task Calendar</title>
    </head>
    <body>
        <!-- Calendar Container -->
        <div id="app" class="calendar">
            <!-- Calendar UI goes here -->
            <calendar :tasks="{{ json_encode($tasks) }}"></calendar>
        </div>

        <!-- Task View Container -->
        <div class="task-view">
            <h2>Task View</h2>
            <ul id="taskList"></ul>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Task Sidebar</h2>
            <ul>
                <!-- Display tasks from the database -->
                @foreach($tasks as $task)
                    <li>{{ $task->event_title }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Include the script for the calendar logic -->
        <script src="{{ asset('js/calendarScript.js') }}"></script>
    </body>
</x-app-layout>
