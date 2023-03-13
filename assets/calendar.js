import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

document.addEventListener("DOMContentLoaded", function () {
  let calendarEl = document.getElementById("calendar");

  let calendar = new Calendar(calendarEl, {
    initialView: "dayGridMonth",
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,listWeek",
    },
    selectable: true,
	
	// Make events clickable 
	select: function(start, end, allDay) {
		console.log("Click")
	},
	// Fetch events
	// events: {
	// 	//url: "{{ path('app_event_index') }}",
	// 	url: "/event/",
	// 	method: "GET",
	// 	failure: function () {
	// 		alert("There was an error fetching events!");
	// 	},
	// }	
	eventSources: [
		{url: window.location.protocol + '//' + window.location.host + '/event/api/events', method: 'GET'} // 
	]
  });

  // calendar.render();

  let newEvent = {
    title: "New Event",
    start: "2023-03-15T10:00:00",
    end: "2023-03-15T12:00:00",
    allDay: false,
  };

  let newEvent2 = {
    title: "New Event",
    start: "2023-03-16T10:00:00",
    end: "2023-03-16T12:00:00",
    allDay: false,
  };

  calendar.addEvent(newEvent);
  calendar.addEvent(newEvent2);
  calendar.render();
});

