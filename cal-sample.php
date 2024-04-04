<?php 

    $pageTitle = "Calendar Dashboard";

     include('header.php'); 

?>

   
    <style>
        .calendar-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2% 0px 0px;
            top: 10%;
            right: 0%;
            width: 100%;
            height: 100%;
        }

        .calendar-wrapper{
            height: max-content;
            width: 100%;;
            background-color: white;
            border-radius: 25px;
            overflow: hidden;
            padding: 30px 50px 30px 50px;
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
                        var formattedDate = date.toISOString().split('T')[0]; // Format date for data-date attribute
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
            var dateString = currentDate.toDateString();
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
                selectedDate.setUTCHours(0, 0, 0, 0); // Set time to midnight in UTC
                console.log('Selected Date:', selectedDate.toISOString()); // Log selected date
                fetchEvents(selectedDate.toISOString()); // Fetch events for selected date
            }
        });

        // Fetch events based on selected date
        function fetchEvents(selectedDate) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_events.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        console.error(response.error);
                    } else {
                        console.log(response); // Log fetched events
                        // Update UI to display fetched events
                        displayEvents(response); // Call function to display fetched events
                    }
                }
            };
            xhr.send('selectedDate=' + selectedDate);
        }

        // Function to display fetched events in the UI
        function displayEvents(events) {
            // Check if events array is empty
            if (events.length === 0) {
                // If no events, display a message
                alert('No events scheduled for the selected date.');
                // You can also update the UI to display a message instead of an alert
            } else {
                // If events are present, you can update the UI to display them
                // For example, you can append the events to a <div> or update a table
                var eventsList = document.getElementById('events-list');
                eventsList.innerHTML = ''; // Clear previous events
                events.forEach(function(event) {
                    // Create HTML elements to display event details
                    var eventItem = document.createElement('div');
                    eventItem.textContent = event.event_name + ' - ' + event.start_from + ' to ' + event.end_to;
                    // Append event item to the events list
                    eventsList.appendChild(eventItem);
                });
            }
        }

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
        
    });


</script>
</body>
</html>