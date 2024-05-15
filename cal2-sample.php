<?php
$pageTitle = "Calendar Dashboard";
include('header.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

<div class="MonthlyEvents">
    <h2>Monthly Events</h2>
    <div id="month_carousel-container" class="owl-carousel owl-theme"></div>
</div>

<script>
    // Define the  function
    function openMap(id) {
        var mapUrl = 'http://192.168.18.39:5173/';
        if (id) {
            mapUrl += '?id=' + id;
        }
        window.open(mapUrl, '_blank');
    }
</script>

<div class="calendar">
    <div class="calendar-container">
        <div class="calendar-wrapper">
            <div class="calendar-header">
                <div class="month-head">
                    <button id="prevMonth"><i class="fa-solid fa-caret-left"></i></button>
                    <div class="month" id="currentMonth"></div>
                    <button id="nextMonth"><i class="fa-solid fa-caret-right"></i></button>
                </div>
                <div class="year-head">
                    <button id="prevYear"><i class="fa-solid fa-caret-left"></i></button>
                    <div class="year" id="currentYear"></div>
                    <button id="nextYear"><i class="fa-solid fa-caret-right"></i></button>
                </div>
            </div>
            <div class="calendar-body">
                <div id="calendar"></div>
                <div class="events">
                    <h2>LIST OF EVENTS</h2>
                    <div id="daily_carousel-container"></div>
                    <a href="<?php echo $redirectURL;?>"><button>Register</button></a>
                </div>
            </div>
            <div class="today">
                <h2>TODAY:</h2>
                <div id="currentDateTime"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Calendar initialization
    const calendarEl = document.getElementById('calendar');
    const currentMonthEl = document.getElementById('currentMonth');
    const currentYearEl = document.getElementById('currentYear');
    const currentDateTimeEl = document.getElementById('currentDateTime');

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
                    var formattedDate = date.toLocaleString().split('T')[0];// Format date for data-date attribute
                    var classes = '';
                    if (date.getDate() === new Date().getDate() && date.getMonth() === new Date().getMonth() && date.getFullYear() === new Date().getFullYear()) {
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
        currentMonthEl.textContent = months[new Date().getMonth()];
        currentYearEl.textContent = new Date().getFullYear();

        var dayOfWeek = days[new Date().getDay()];
        var dateString = new Date().toLocaleDateString();
        var timeString = new Date().toLocaleTimeString();
        currentDateTimeEl.innerHTML = dayOfWeek + ', ' + dateString + '<br><span class="time">' + timeString  + '</span>';
    }

    // Initialize calendar
    renderCalendar(new Date().getFullYear(), new Date().getMonth());
    updateCurrentDateDisplay();

    // Add event listeners for calendar navigation
    document.getElementById('prevYear').addEventListener('click', () => {
        const currentYear = new Date().getFullYear();
        renderCalendar(currentYear - 1, new Date().getMonth());
        updateCurrentDateDisplay();
    });

    document.getElementById('prevMonth').addEventListener('click', () => {
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();
        if (currentMonth === 0) {
            renderCalendar(currentYear - 1, 11);
        } else {
            renderCalendar(currentYear, currentMonth - 1);
        }
        updateCurrentDateDisplay();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();
        if (currentMonth === 11) {
            renderCalendar(currentYear + 1, 0);
        } else {
            renderCalendar(currentYear, currentMonth + 1);
        }
        updateCurrentDateDisplay();
    });

    document.getElementById('nextYear').addEventListener('click', () => {
        const currentYear = new Date().getFullYear();
        renderCalendar(currentYear + 1, new Date().getMonth());
        updateCurrentDateDisplay();
    });

    // Add event listener for calendar cell clicks
    calendarEl.addEventListener('click', (event) => {
        if (event.target.tagName === 'TD') {
            const selectedDate = new Date(event.target.getAttribute('data-date'));
            fetchEventsForSelectedDate(selectedDate);
        }
    });

    // Function to fetch events for a selected date
    async function fetchEventsForSelectedDate(selectedDate) {
        try {
            const response = await fetch('display_fetch.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `selectedDate=${selectedDate.toLocaleString().split('T')[0]}`,
            });
            const data = await response.json();
            displayEvents(data, selectedDate);
        } catch (error) {
            console.error('Error fetching events:', error);
        }
    }

    // Function to display events in the carousel
    function displayEvents(events, selectedDate) {
        const dailyEventsCarouselContainer = document.getElementById('daily_carousel-container');
        if (events.length > 0) {
            // Clear existing content
            dailyEventsCarouselContainer.innerHTML = '';

            // Iterate over events and create carousel items
            events.forEach((event) => {
                const carouselItem = document.createElement('div');
                carouselItem.classList.add('carousel-item');
                carouselItem.innerHTML = `
                    <div class="event-preview">
                        <h3>${event.event_name}</h3>
                        <p><span>Event Code: </span> ${event.event_code}</p>
                        <p><span>Duration: </span> ${event.start_from} - ${event.end_to}</p>
                        <p><span>Status: </span> ${event.event_status}</p>
                        <!-- Add other event details as needed -->
                        <div class="event-details" >
                            <p><span>Event Purpose: </span> ${event.event_purpose}</p>
                            <p><span>Participants: </span> ${event.participants}</p>
                            <p><span>Host: </span> ${event.first_name} ${event.last_name}</p>
                            <p><span>Facility: </span> ${event.facility_name} - ${event.building_loc}</p>
                            <button class="navigate-button" onclick="openMap(${event.event_ID})">Navigate</button>
                            <!-- Add other event details as needed -->
                        </div>
                    </div>
                `;
                dailyEventsCarouselContainer.appendChild(carouselItem);

                // Event listener to toggle event details on click
                carouselItem.addEventListener('click', () => {
                    const eventDetails = carouselItem.querySelector('.event-details');
                    eventDetails.classList.toggle('show');
                });
            });
        } else {
            dailyEventsCarouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
        }
    }

    // Initialize Owl Carousel
    $(document).ready(function() {
        const monthEventsCarouselContainer = document.getElementById('month_carousel-container');
        $(monthEventsCarouselContainer).owlCarousel({
            loop: true,
            margin: 5,
            autoplay: true,
            autoplayTimeout: 3000, // autoscroll every 5 seconds
            autoplayHoverPause: true, // pause autoplay on hover
            items: 1,
            center: true,
            dots: false, // show dots navigation
            nav: false, // show prev/next navigation
            smartSpeed: 500, // animation speed
            onTranslate: function() {
                $(this).find('.owl-item').not('.cloned').removeClass('animated zoomIn');
                $(this).find('.owl-item.active').not('.cloned').addClass('animated zoomIn');
            },
        });
    });

    // Function to fetch events for the current date
    function fetchEventsForCurrentDate() {
        const currentDate = new Date();
        fetchEventsForSelectedDate(currentDate);
    }

    // Call fetchEventsForCurrentDate function when the page loads
    fetchEventsForCurrentDate();
</script>

<?php
include('footer.php');
?>