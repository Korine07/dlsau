<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar Test</title>

   <!-- FullCalendar v6 - Correct Import -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

</head>
<body>

    <h2>FullCalendar Test</h2>
    <div id="calendar"></div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("FullCalendar is initializing...");

        var calendarEl = document.getElementById("calendar");

        if (!calendarEl) {
            console.error("Calendar element not found!");
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay"
            },
            events: "/calendar-events", // Fetch events from Laravel
            editable: true,
            selectable: true,
            dateClick: function(info) {
                alert("Clicked on: " + info.dateStr);
            },
            eventClick: function(info) {
                alert("Event: " + info.event.title);
            }
        });

        console.log("Rendering calendar...");
        calendar.render();
    });
</script>



</body>
</html>
