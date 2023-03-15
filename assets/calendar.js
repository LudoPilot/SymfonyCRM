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
	  // Make the events clickable
	  // eventClick callback

	  /*
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
		//let end = info.event.end ? info.event.end.toISOString().slice(0, -8) : null;
	  
		// Add event listener to Save Changes button
		let saveBtn = document.querySelector("#createEditEventModal .save-btn");
		saveBtn.addEventListener("click", function () {
		  // Create FormData object from form
		  let formData = new FormData(form);
	  
		  // Serialize FormData object into JSON object
		  let data = {};
		  formData.forEach(function (value, key) {
			data[key] = value;
		  });
	  
		  // Add event ID to JSON object
		  data.id = info.event.id;
	  
		  // Send PUT request with updated information
		  fetch(window.location.protocol + '//' + window.location.host + '/event/api/events/' + info.event.id, {
			method: 'PUT',
			body: JSON.stringify(data),
			headers: {
			  'Content-Type': 'application/json'
			}
		  })
		  .then(response => response.json())
		  .then(data => console.log(data))
		  .catch(error => console.error(error));
	  
		  // Close modal
		  modal.style.display = "none";
		  modal.classList.remove("show");
		  document.body.classList.remove("modal-open");
		});
	  }, */

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
		//let end = info.event.end ? info.event.end.toISOString().slice(0, -8) : null;
	  
		// Add event listener to Save Changes button
		let saveBtn = document.querySelector("#createEditEventModal .save-btn");
		saveBtn.addEventListener("click", function () {
		  // Create FormData object from form
		  let formData = new FormData(form);
	  
		  // Serialize FormData object into JSON object
		  let data = {};
		  formData.forEach(function (value, key) {
			data[key] = value;
		  });
	  
		  // Add event ID to JSON object
		  data.id = info.event.id;
	  
		  // Send PUT request with updated information
		  fetch(window.location.protocol + '//' + window.location.host + '/event/api/events/' + info.event.id, {
			method: 'PUT',
			body: JSON.stringify(data),
			headers: {
			  'Content-Type': 'application/json'
			}
		  })
		  .then(response => response.json())
		  .then(data => console.log(data))
		  .catch(error => console.error(error));
	  
		  // Close modal
		  modal.style.display = "none";
		  modal.classList.remove("show");
		  document.body.classList.remove("modal-open");
		});
	  
		// Add event listener for event resize
		info.jsEvent.preventDefault();
		let oldEvent = info.event;
		calendar.unselect();
		calendar.addEvent(oldEvent);
	  
		calendar.on("eventResize", function (info) {
		  let newEvent = info.event;
		  let data = {
			id: oldEvent.id,
			title: newEvent.title,
			start: newEvent.start.toISOString(),
			end: newEvent.end ? newEvent.end.toISOString() : null,
		  };
	  
		  fetch(window.location.protocol + '//' + window.location.host + '/event/api/events/' + oldEvent.id, {
			method: 'PUT',
			body: JSON.stringify(data),
			headers: {
			  'Content-Type': 'application/json'
			}
		  })
		  .then(response => response.json())
		  .then(data => console.log(data))
		  .catch(error => console.error(error));
		});
	  
		// Add event listener for event deletion
		let deleteBtn = document.querySelector("#createEditEventModal .delete-btn");
		deleteBtn.addEventListener("click", function () {
			console.log("Bouton pressé")
		  fetch(window.location.protocol + '//' + window.location.host + '/event/calendar/' + info.event.id, {
			method: 'DELETE'
		  })
		  .then(response => response.json())
		  //.then(data => console.log(data))
		  .then(data => {
			console.log(data);
			console.log(typeof data);
		})
		  .catch(error => console.error(error));
	  
		  // Close modal
		  modal.style.display = "none";
		  modal.classList.remove("show");
		  document.body.classList.remove("modal-open");
		});
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