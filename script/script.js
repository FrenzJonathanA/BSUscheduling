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
    
    month_picker.innerHTML = month_names[month];
    
    calendar_header_year.innerHTML = year;
    
    let first_day = new Date(year, month);
  
  
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
              const response = await fetch(`fetch_events.php?date=${date}`);
              const data = await response.json();
              return data;
          } catch (error) {
              console.error('Error fetching events:', error);
              return [];
          }
      };

      // Function to display events or no-events message
      const displayEvents = (events) => {
          eventsContainer.innerHTML = '';
          if (events.length > 0) {
              // Construct HTML table to display events
              let eventTable = '<table><thead><tr><th>Event Name</th><th>Event Purpose</th></tr></thead><tbody>';
              events.forEach(event => {
                  eventTable += `<tr><td>${event['event_name']}</td><td>${event['event_purpose']}</td></tr>`;
              });
              eventTable += '</tbody></table>';
              eventsContainer.innerHTML = eventTable;
          } else {
              eventsContainer.textContent = 'No events scheduled for this date.';
          }
          eventsContainer.style.display = 'block';
      };

      // Event listener for clicking on calendar days
      calendarDays.forEach(day => {
          day.addEventListener('click', async () => {
              const selectedDate = day.textContent;
              const selectedMonth = document.querySelector('#month-picker').textContent;
              const selectedYear = document.querySelector('#year').textContent;
              const selectedDateString = `${selectedYear}-${selectedMonth}-${selectedDate}`; // Assuming date format matches database format
              const events = await fetchEvents(selectedDateString);
              displayEvents(events);
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























