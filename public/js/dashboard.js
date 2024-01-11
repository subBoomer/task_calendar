document.addEventListener('DOMContentLoaded', function () {
    // FullCalendar for the main calendar
    var calendarEl = document.querySelector('#calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            {
                title: 'Meeting',
                start: '2022-01-10T10:00:00',
                end: '2022-01-10T12:00:00',
            },
            {
                title: 'Lunch',
                start: '2022-01-12T12:00:00',
                end: '2022-01-12T13:30:00',
            },
            // Add more events as needed
        ],
    });

    calendar.render();

    // Placeholder for the mini-calendar
    var miniCalendarEl = document.getElementById('mini-calendar');
    // You can configure the mini-calendar separately if needed
    // var miniCalendar = new FullCalendar.Calendar(miniCalendarEl, { /* Mini-calendar configuration */ });
    // miniCalendar.render();
});
