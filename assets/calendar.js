import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

//import "./index.css";

document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("calendar");

    let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        selectable: true,
        //   dateClick: function(info) {
        // 	alert('Clicked on: ' + info.dateStr);
        // 	alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        // 	alert('Current view: ' + info.view.type);
        // 	// change the day's background color just for fun
        // 	info.dayEl.style.backgroundColor = 'lightblue';
        //   }
		dateClick: function (info) {
			let modalEl = document.getElementById("createEventModal");
			let modalContentEl = modalEl.querySelector(".modal-content");
			let url = "{{ path('app_event_new') }}";
		
			fetch(url)
				.then((response) => response.text())
				.then((html) => {
					modalContentEl.innerHTML = html;
					new bootstrap.Modal(modalEl).show();
				});
		
			// change the day's background color just for fun
			info.dayEl.style.backgroundColor = "lightblue";
		},
    });

    calendar.render();
});
