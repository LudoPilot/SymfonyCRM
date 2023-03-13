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

    dateClick: function (info) {
		console.log("clicked " + info.dateStr);
		// open modal here
		let modal = document.getElementById("createEventModal");
		modal.style.display = "block";
		modal.classList.add("show");
	  },
	// Fetch events
	eventSources: [
		{url: window.location.protocol + '//' + window.location.host + '/event/api/events', method: 'GET'} // 
	]
  });

  // Demo events, just to try if the calendar displays them
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
  // Add click event listener to document to close modal
  document.addEventListener("click", function (event) {
    let modal = document.getElementById("createEventModal");
    if (event.target == modal) {
      modal.style.display = "none";
      modal.classList.remove("show");
    }
  });

});

