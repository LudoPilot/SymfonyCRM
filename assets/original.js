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
	nowIndicator: true,
    selectable: true,
	// make the dates clickable
    dateClick: function (info) {
		console.log("clicked " + info.dateStr);
		// open modal here
		let modal = document.getElementById("createEventModal");
		modal.style.display = "block";
		modal.classList.add("show");
	  },

	/* Alternative version with select */
	// select: function(info) {
	// 	console.log("selected " + info.startStr + " to " + info.endStr);
	// 	// open modal here
	// 	let modal = document.getElementById("createEventModal");
	// 	modal.style.display = "block";
	// 	modal.classList.add("show");
	//   },

	// Make the events clickable
    // eventClick callback
    eventClick: function (info) {
        // log event object
        console.log("clicked event: ", info.event);

        // open the edit modal
        let modal = document.getElementById("createEditEventModal");
        modal.classList.add("show");
        modal.style.display = "block";
        document.body.classList.add("modal-open");

        // Prefill the edit form with the event data
        let form = document.querySelector("#createEditEventModal form");
		form.elements["editEventTitle"].value = info.event.title;
		form.elements["editEventStart"].value = info.event.start.toISOString().slice(0, -8);
		form.elements["editEventEnd"].value = info.event.end.toISOString().slice(0, -8);
    },	  

	// Fetch events
	eventSources: [
		{url: window.location.protocol + '//' + window.location.host + '/event/api/events', method: 'GET'} // 
	]
  });
  calendar.render();

  // Add click event listener to document to close modal
  document.addEventListener("click", function (event) {
    let modal = document.getElementById("createEventModal");
    if (event.target == modal) {
      modal.style.display = "none";
      modal.classList.remove("show");
    }
  });

  // Add click event listener to document to close the edit modal
  document.addEventListener("click", function (event) {
	let modal = document.getElementById("createEditEventModal");
	if (event.target == modal) {
	  modal.style.display = "none";
	  modal.classList.remove("show");
	  document.body.classList.remove("modal-open");
	}
  });

});
