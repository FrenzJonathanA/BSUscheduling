<?php 

    $pageTitle = "Calendar Dashboard";

     include('header.php'); 

?>

   
    <style>
        .calendar-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 2% 0px 0px;
            top: 10%;
            right: 0%;
            width: 100%;
            height: 100%;
        }

        .calendar-wrapper{
            height: max-content;
            margin: 0 auto;
            background-color: white;
            border-radius: 25px;
            //overflow: hidden;
            padding: 30px 50px;
            box-shadow: var(--shadow);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: #007bff; /* Set background color for calendar header */
            color: #fff; /* Set text color for calendar header */
            padding: 10px; /* Add padding to the calendar header */
            text-align: center;
            padding: 15px
            
        }

        .month-head, .year-head{
            button{
                background-color: transparent;
                border: none;
                font-size: 15px;
            }
        }

        .month, .year {
            font-size: 25px;
            font-weight: bold;
            
        }
        .calendar-body{
            border: 1px solid #ccc;
            padding: 25px;
        } 

        #calendar {
            display: grid;
            /* grid-template-columns: repeat(7, 1fr); */
            font-weight: 600;
            cursor: pointer;
            color: rgb(104, 104, 104);
            width: 100%;
        }


        .today {
            margin-top: 20px;
            text-align: center;
            margin-top: 50px;
            border-top: 1px solid;
        }

        .today h2 {
            margin-bottom: 10px;
        }

        #currentDateTime {
            font-size: 18px;
            font-weight: bold;
        }

        span.time {
            font-size: 36px;
            margin-top: 15px;
            color: #333; /* Example color */
            /* Add any other styles you want */
        }

        /* CSS for calendar cells */
        #calendar td {
            padding: 15px;
            text-align: center;
            cursor: pointer;
            font-size: 20px;
            //border: 1px solid #ccc;
        }

        
        thead{
            margin: 25px 0;
            text-align: center;
            cursor: pointer;
            font-size: 20px;
        }

        /* CSS for hover effect */
        #calendar td:hover {
            background-color: #f0f0f0;
        }

        /* CSS for active effect */
        #calendar td.active {
            background-color: #007bff; /* Change background color when clicked */
            color: #fff; /* Change text color when clicked */
        }
        /* CSS for emphasizing the current date */
        #calendar td.current-date {
            background-color: #007bff; /* Change background color of the current date */
            color: #fff; /* Change text color of the current date */
        }


    
    </style>


<body>
    <!-- Scheduling Form -->
    <div class="calendar">
        <div class="calendar-container">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <div class="month-head" style="display: flex; gap: 5px;">
                        <button id="prevMonth"><i class="fa-solid fa-caret-left" ></i></button>
                        <div class="month" id="currentMonth"></div>
                        <button id="nextMonth"><i class="fa-solid fa-caret-right"></i></i></button>
                    </div>
                    <div class="year-head" style="display: flex; gap: 5px;">
                        <button id="prevYear"><i class="fa-solid fa-caret-left"></i></i></button>
                        <div class="year" id="currentYear"></div>
                        <button id="nextYear"><i class="fa-solid fa-caret-right"></i></i></button>
                    </div>
                </div>
                <div class="calendar-body">
                    <div id="calendar">
                    
                    </div>
                    <div class="today">
                        <h2>TODAY:</h2>
                        <div id="currentDateTime"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="events-container">
        <!-- Event details container -->
    </div>









    <style>
        /* CSS for the carousel container */
        #carousel-container {
            width: 80%;
            margin: 0 auto;
        }

        /* CSS for individual carousel items */
        .carousel-item {
            background-color: #f0f0f0;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            cursor: pointer; /* Change cursor to pointer when hovering over carousel items */
            max-width: 50%;
            margin: 50px auto;
        }

        .carousel-item h3 {
            margin-top: 0;
        }

        .carousel-item p {
            margin: 5px 0;
        }

        /* CSS for full event details */
        .event-details {
            display: none; /* Initially hide event details */
            padding: 20px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .event-details.show {
            display: block; /* Show event details when .show class is added */
        }
    </style>
</head>

<body>
    <div id="carousel-container"></div>

    <!-- Add any necessary JavaScript code here -->
    <script>
        // Function to fetch events from the server
        const fetchEvents = async (selectedDate) => {
            try {
                // Send an AJAX request to fetch events for the selected date
                const response = await fetch('fetch_events.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `selectedDate=${selectedDate}`,
                });
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error fetching events:', error);
                return [];
            }
        };

        // Function to display events in the carousel
        const displayEvents = (events) => {
            const carouselContainer = document.getElementById('carousel-container');
            if (events.length > 0) {
                // Clear existing content
                carouselContainer.innerHTML = '';

                // Iterate over events and create carousel items
                events.forEach(event => {
                    const carouselItem = document.createElement('div');
                    carouselItem.classList.add('carousel-item');
                    carouselItem.innerHTML = `
                        <h3>${event.event_name}</h3>
                        <p>Event Code: ${event.event_code}</p>
                        <p>Duration: ${event.start_from} - ${event.end_to}</p>
                        <p>Status: ${event.event_status}</p>
                        <!-- Add other event details as needed -->
                        <div class="event-details">
                            <p>Event Purpose: ${event.event_purpose}</p>
                            <p>Participants: ${event.participants}</p>
                            <p>Host: ${event.first_name} ${event.last_name}</p>
                            <p>Facility: ${event.facility_name}</p>
                            <!-- Add other event details as needed -->
                        </div>
                    `;
                    carouselContainer.appendChild(carouselItem);

                    // Event listener to toggle event details on click
                    carouselItem.addEventListener('click', () => {
                        const eventDetails = carouselItem.querySelector('.event-details');
                        eventDetails.classList.toggle('show');
                    });
                });
            } else {
                // No events scheduled
                carouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
            }
        };

        // Get the current local date
        const currentDate = new Date();
        const currentDateString = currentDate.toISOString().split('T')[0];

        // Fetch events and display them in the carousel
        fetchEvents(currentDateString).then(displayEvents);
    </script>



    
    <?php 
    include('footer.php'); 
    ?>'


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth();
        var currentDay = currentDate.getDate(); // Get the current day
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var calendarEl = document.getElementById('calendar');
        var currentMonthEl = document.getElementById('currentMonth');
        var currentYearEl = document.getElementById('currentYear');
        var currentDateTimeEl = document.getElementById('currentDateTime');

        function renderCalendar(year, month) {
            var daysInMonth = new Date(year, month + 1, 0).getDate();
            var firstDayOfMonth = new Date(year, month, 1).getDay();
            var html = '<table>';
            html += '<thead><tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead>';
            html += '<tbody>';

            var dayCounter = 1; // Start dayCounter from 1
            for (var i = 0; i < 6; i++) {
                html += '<tr>';
                for (var j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayOfMonth) {
                        html += '<td></td>';
                    } else if (dayCounter > daysInMonth) {
                        break;
                    } else {
                        var date = new Date(year, month, dayCounter);
                        var formattedDate = date.toLocaleString().split('T')[0]; // Format date for data-date attribute
                        var classes = '';
                        if (date.getDate() === currentDay && date.getMonth() === currentMonth && date.getFullYear() === currentYear) {
                            classes = 'current-date';
                        }
                        html += '<td class="' + classes + '" data-date="' + formattedDate + '">' + dayCounter + '</td>';
                        dayCounter++;
                    }
                }
                html += '</tr>';
                if (dayCounter > daysInMonth) {
                    break;
                }
            }
            
            html += '</tbody></table>';
            calendarEl.innerHTML = html;
        }

        function updateCurrentDateDisplay() {
            currentMonthEl.textContent = months[currentMonth];
            currentYearEl.textContent = currentYear;

            var dayOfWeek = days[currentDate.getDay()];
            var dateString = currentDate.toLocaleDateString();
            var timeString = currentDate.toLocaleTimeString();
            currentDateTimeEl.innerHTML = dayOfWeek + ', ' + dateString + '<br><span class="time">' + timeString  + '</span>';
        }

        renderCalendar(currentYear, currentMonth);
        updateCurrentDateDisplay();

        // Update time every second
        setInterval(function() {
            currentDate = new Date();
            updateCurrentDateDisplay();
            emphasizeCurrentDate(); // Call function to emphasize current date
        }, 1000);

        document.getElementById('prevYear').addEventListener('click', function() {
            currentYear--;
            renderCalendar(currentYear, currentMonth);
        });

        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentYear, currentMonth);
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentYear, currentMonth);
        });

        document.getElementById('nextYear').addEventListener('click', function() {
            currentYear++;
            renderCalendar(currentYear, currentMonth);
        });


        // Handle click event on calendar cells
        calendarEl.addEventListener('click', function(event) {
            if (event.target.tagName === 'TD') {
                var selectedDate = new Date(event.target.getAttribute('data-date'));
                //selectedDate.setUTCHours(0, 0, 0, 0); // Set time to midnight in UTC
                console.log('Selected Date:', selectedDate.toLocaleDateString()); // Log selected date
                fetchEvents(selectedDate.toLocaleString()); // Fetch events for selected date
            }
        });


        // Emphasize current date in the calendar
        function emphasizeCurrentDate() {
            var cells = document.querySelectorAll('#calendar td');
            cells.forEach(function(cell) {
                cell.classList.remove('current-date'); // Remove existing emphasis
                var date = new Date(cell.getAttribute('data-date'));
                if (date.getDate() === currentDay && date.getMonth() === currentMonth && date.getFullYear() === currentYear) {
                    cell.classList.add('current-date'); // Add emphasis to current date
                }
            });
        }


        // Function to fetch events from the server
        function fetchEvents(selectedDate) {
            // Send a POST request to fetch_events.php with the selected date
            $.post('fetch_events.php', { selectedDate: selectedDate }, function(data) {
                // Print out the JSON response for debugging
                console.log(data);

                try {
                    // Parse the JSON response
                    var events = JSON.parse(data);

                    // Display the fetched events in the UI
                    displayEvents(events, selectedDate);
                } catch (error) {
                    // If there was an error parsing the JSON response, display an error message
                    alert('Error: ' + error.message);
                }
            });
        }

        // Fetch events and display them in the carousel
        fetchEvents(currentDateString).then(displayEvents);

        const displayEvents = (events, selectedDate) => {
            const carouselContainer = document.getElementById('carousel-container');
            if (events.length > 0) {
                // Clear existing content
                carouselContainer.innerHTML = '';

                // Iterate over events and create carousel items
                events.forEach(event => {
                    const carouselItem = document.createElement('div');
                    carouselItem.classList.add('carousel-item');
                    carouselItem.innerHTML = `
                        <h3>${event.event_name}</h3>
                        <p>Event Code: ${event.event_code}</p>
                        <p>Duration: ${event.start_from} - ${event.end_to}</p>
                        <p>Status: ${event.event_status}</p>
                        <!-- Add other event details as needed -->
                        <div class="event-details">
                            <p>Event Purpose: ${event.event_purpose}</p>
                            <p>Participants: ${event.participants}</p>
                            <p>Host: ${event.host_first_name} ${event.host_last_name}</p>
                            <p>Facility: ${event.facility_name}</p>
                            <!-- Add other event details as needed -->
                        </div>
                    `;
                    carouselContainer.appendChild(carouselItem);

                    // Event listener to toggle event details on click
                    carouselItem.addEventListener('click', () => {
                        const eventDetails = carouselItem.querySelector('.event-details');
                        eventDetails.classList.toggle('show');
                    });
                });
            } else {
                // No events scheduled
                carouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
            }
        };








    });


</script>
</body>
</html>