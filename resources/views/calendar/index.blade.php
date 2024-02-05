<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css" media="print" />
        <title>Task Calendar</title>
    </head>
    <body>
        <div id="app">
            <full-calendar :tasks="{{ json_encode($tasks) }}" :current-user="{{ json_encode(auth()->user()) }}"></full-calendar>
            <tasks-sidebar></tasks-sidebar>
        </div>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
        @vite(['resources/js/app.js'])
    </body>
</x-app-layout>