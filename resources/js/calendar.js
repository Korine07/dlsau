import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    if (!calendarEl) {
        console.error("Calendar element not found!");
        return;
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [FullCalendar.DayGrid, FullCalendar.TimeGrid, FullCalendar.Interaction],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/calendar-events' // Fetch events from backend
    });

    calendar.render();
});
