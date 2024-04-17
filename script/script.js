  const isLeapYear = (year) => {
    return (
      (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
      (year % 100 === 0 && year % 400 === 0)
    );
  };
  const getFebDays = (year) => {
    return isLeapYear(year) ? 29 : 28;
  };
  let calendar = document.querySelector('.calendar');
  const month_names = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  ];
  let month_picker = document.querySelector('#month-picker');
  const dayTextFormate = document.querySelector('.day-text-formate');
  const timeFormate = document.querySelector('.time-formate');
  const dateFormate = document.querySelector('.date-formate');
  
  month_picker.onclick = () => {
    month_list.classList.remove('hideonce');
    month_list.classList.remove('hide');
    month_list.classList.add('show');
    dayTextFormate.classList.remove('showtime');
    dayTextFormate.classList.add('hidetime');
    timeFormate.classList.remove('showtime');
    timeFormate.classList.add('hideTime');
    dateFormate.classList.remove('showtime');
    dateFormate.classList.add('hideTime');
  };
  
  // const generateCalendar = (month, year) => {
  //   let calendar_days = document.querySelector('.calendar-days');
  //   calendar_days.innerHTML = '';
  //   let calendar_header_year = document.querySelector('#year');
  //   let days_of_month = [
  //     31,
  //     getFebDays(year),
  //     31,
  //     30,
  //     31,
  //     30,
  //     31,
  //     31,
  //     30,
  //     31,
  //     30,
  //     31,
  //   ];
    
  //   let currentDate = new Date();
    
  //   month_picker.innerHTML = month_names[month];
    
  //   calendar_header_year.innerHTML = year;
    
  //   let first_day = new Date(year, month);
  
  
  // for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
  
  //     let day = document.createElement('div');
  
  //     if (i >= first_day.getDay()) {
  //       day.innerHTML = i - first_day.getDay() + 1;

  //       if (i - first_day.getDay() + 1 === currentDate.getDate() &&
  //         year === currentDate.getFullYear() &&
  //         month === currentDate.getMonth()
  //       ) {
  //         day.classList.add('current-date');
  //       }
  //     }
  //     calendar_days.appendChild(day);
  //   }
  // };
  
  // Function to generate calendar for a specific month and year
  const generateCalendar = (month, year) => {
    let calendar_days = document.querySelector('.calendar-days');
    calendar_days.innerHTML = '';
    let calendar_header_year = document.querySelector('#year');
    let days_of_month = [
        31,
        getFebDays(year),
        31,
        30,
        31,
        30,
        31,
        31,
        30,
        31,
        30,
        31,
    ];

    let currentDate = new Date();

    // Update the month displayed in the month picker
    month_picker.innerHTML = month_names[month];

    // Update the year displayed in the calendar header
    calendar_header_year.innerHTML = year;

    // Calculate the first day of the selected month
    let first_day = new Date(year, month);

    // Loop through the days of the month and create calendar cells
    for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {

        let day = document.createElement('div');

        if (i >= first_day.getDay()) {
            day.innerHTML = i - first_day.getDay() + 1;

            if (i - first_day.getDay() + 1 === currentDate.getDate() &&
                year === currentDate.getFullYear() &&
                month === currentDate.getMonth()
            ) {
                day.classList.add('current-date');
            }
        }
        calendar_days.appendChild(day);
    }
  };


  let month_list = calendar.querySelector('.month-list');
  month_names.forEach((e, index) => {
    let month = document.createElement('div');
    month.innerHTML = `<div>${e}</div>`;
  
    month_list.append(month);
    month.onclick = () => {
      currentMonth.value = index;
      generateCalendar(currentMonth.value, currentYear.value);
      month_list.classList.replace('show', 'hide');
      dayTextFormate.classList.remove('hideTime');
      dayTextFormate.classList.add('showtime');
      timeFormate.classList.remove('hideTime');
      timeFormate.classList.add('showtime');
      dateFormate.classList.remove('hideTime');
      dateFormate.classList.add('showtime');
    };
  });
  
  (function () {
    month_list.classList.add('hideonce');
  })();
  document.querySelector('#pre-year').onclick = () => {
    --currentYear.value;
    generateCalendar(currentMonth.value, currentYear.value);
  };
  document.querySelector('#next-year').onclick = () => {
    ++currentYear.value;
    generateCalendar(currentMonth.value, currentYear.value);
  };
  
  let currentDate = new Date();
  let currentMonth = { value: currentDate.getMonth() };
  let currentYear = { value: currentDate.getFullYear() };
  generateCalendar(currentMonth.value, currentYear.value);

  const todayShowTime = document.querySelector('.time-formate');
  const todayShowDate = document.querySelector('.date-formate');
  
  const currshowDate = new Date();
  const showCurrentDateOption = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    weekday: 'long',
  };
  const currentDateFormate = new Intl.DateTimeFormat(
    'en-US',
    showCurrentDateOption
  ).format(currshowDate);
  todayShowDate.textContent = currentDateFormate;
  setInterval(() => {
    const timer = new Date();
    const option = {
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric',
    };
    const formateTimer = new Intl.DateTimeFormat('en-us', option).format(timer);
    let time = `${`${timer.getHours()}`.padStart(
      2,
      '0'
    )}:${`${timer.getMinutes()}`.padStart(
      2,
      '0'
    )}: ${`${timer.getSeconds()}`.padStart(2, '0')}`;
    todayShowTime.textContent = formateTimer;
  }, 1000);





  document.addEventListener('DOMContentLoaded', function () {
      const calendarDays = document.querySelectorAll('.calendar-days div');
      const eventsContainer = document.querySelector('.events-container');

      // Function to fetch events from the server
      const fetchEvents = async (date) => {
          try {
              // Send an AJAX request to fetch events for the selected date
              const response = await fetch('fetch_events.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/x-www-form-urlencoded',
                  },
                  body: `selectedDate=${date}`,
              });
              const data = await response.json();
              return data;
          } catch (error) {
              console.error('Error fetching events:', error);
              return [];
          }
      };

      // Function to display events in a pop-up container
      const displayEventsInPopup = (events, selectedDate) => {
          // Create a pop-up container
          const popupContainer = document.createElement('div');
          popupContainer.classList.add('popup-container');

          // Add a close button to the pop-up container
          const closeButton = document.createElement('button');
          closeButton.textContent = 'Close';
          closeButton.addEventListener('click', () => {
              popupContainer.remove(); // Remove the pop-up container when the close button is clicked
          });
          popupContainer.appendChild(closeButton);

          // Add a heading to the pop-up container
          const heading = document.createElement('h2');
          heading.textContent = 'Events for ' + selectedDate.toLocaleDateString();
          popupContainer.appendChild(heading);

          // Check if there are events for the selected date
          if (events.length > 0) {
              // Iterate over events and create elements to display event details
              events.forEach(event => {
                  const eventElement = document.createElement('div');
                  eventElement.classList.add('event-details');

                  // Add event details to the element
                  eventElement.innerHTML = `
                      <h3>${event.event_name}</h3>
                      <p>Event Code: ${event.event_code}</p>
                      <p>Duration: ${event.start_from} - ${event.end_to}</p>
                      <p>Status: ${event.event_status}</p>
                      <!-- Add other event details as needed -->
                  `;

                  // Add the event element to the pop-up container
                  popupContainer.appendChild(eventElement);
              });
          } else {
              // If there are no events, display a message
              const message = document.createElement('p');
              message.textContent = 'No events scheduled for this date.';
              popupContainer.appendChild(message);
          }

          // Create a button to redirect to the request form
          const requestFormButton = document.createElement('button');
          requestFormButton.textContent = 'Request Form';
          requestFormButton.addEventListener('click', () => {
              // Redirect to the request form page
              window.location.href = 'request-form.php';
          });
          popupContainer.appendChild(requestFormButton);

          // Append the pop-up container to the body
          document.body.appendChild(popupContainer);
      };

      // Event listener for clicking on calendar days
      calendarDays.forEach(day => {
          day.addEventListener('click', async () => {
              const selectedDate = day.textContent;
              const selectedMonth = document.querySelector('#month-picker').textContent;
              const selectedYear = document.querySelector('#year').textContent;
              const selectedDateString = `${selectedYear}-${selectedMonth}-${selectedDate}`; // Assuming date format matches database format
              const events = await fetchEvents(selectedDateString);
              displayEventsInPopup(events, new Date(selectedDateString));
          });
      });
  });




// $(document).ready(function() {
//     // Edit Button Click Event
//     $('.edit-button').click(function() {
//         var departmentCode = $(this).data('code');
//         var departmentName = $(this).data('name');
//         // Populate the form fields with current department details
//         $('#edit_department_code').val(departmentCode);
//         $('#edit_department_name').val(departmentName);
//         // Show the update button and hide the add button
//         $('#update-department-button').show();
//         $('#add-department-button').hide();
//     });
//     // Update Department Form Submission via AJAX
//     $('#edit-department-form').submit(function(e) {
//         e.preventDefault(); // Prevent default form submission
//         // Serialize form data
//         var formData = $(this).serialize();
//         // Send AJAX request
//         $.ajax({
//             url: $(this).attr('action'), // Form action URL
//             type: $(this).attr('method'), // Form method (POST)
//             data: formData, // Form data
//             success: function(response) {
//                 // Check if update was successful
//                 if (response == 'success') {
//                     // Redirect to the dashboard after successful update
//                     window.location.href = './depart_categ.php';
//                 } else {
//                     // Handle update failure (display error message, etc.)
//                     console.log('Update failed');
//                 }
//             },
//             error: function() {
//                 // Handle AJAX error
//                 console.log('AJAX error');
//             }
//         });
//     });
// });























