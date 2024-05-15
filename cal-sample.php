<?php
    $pageTitle = "Calendar Dashboard";
    include('header.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="scss/style.css">

<div class="MonthlyEvents">
    <h2>Monthly Events</h2>
    <div id="carouselSlide-container" class="owl-carousel owl-theme"></div>
</div>
<script>
    
    // Define the openMap function
    function openMap(id) {
        var mapUrl = 'http://192.168.18.39:5173/';
        if (id) {
            mapUrl += '?id=' + id;
        }
        window.open(mapUrl, '_blank');
    }

    // Function to fetch events from the server
    const month_fetchMonthEvents = async (selectedDate) => {
        try {
            // Send an AJAX request to fetch events for the selected date
            const response = await fetch('display_fetch.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `selectedDate=${selectedDate}`,
            });
            const data = await response.json();
            console.log('Data:', data); // Add a log statement to check the data
            return data;
        } catch (error) {
            console.error('Error fetching events:', error);
            return [];
        }
    };

    // Function to display events in the carousel
    const month_displayMonthEvents = (events) => {
        const carouselSlideContainer = document.getElementById('carouselSlide-container');
        if (events.length > 0) {
            // Clear existing content
            carouselSlideContainer.innerHTML = '';

            // Iterate over events and create carousel items
            events.forEach((event) => {
                const carouselSlideItem = document.createElement('div');
                carouselSlideItem.classList.add('carouselSlide-item');
                carouselSlideItem.innerHTML = `
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
                carouselSlideContainer.appendChild(carouselSlideItem);

                // Event listener to toggle event details on click
                carouselSlideItem.addEventListener('click', () => {
                    const eventDetails = carouselSlideItem.querySelector('.event-details');
                    eventDetails.classList.toggle('show');
                });
            });
            console.log('Carousel items appended:', carouselSlideContainer.innerHTML); 
            // Initialize Owl Carousel
            $(carouselSlideContainer).owlCarousel({
                loop: true,
                margin: 5,
                autoplay: true,
                autoplayTimeout: 3000, 
                autoplayHoverPause: true, 
                items: 1,
                center: true,
                dots: false, 
                smartSpeed: 500, 
                onTranslate: function() {
                    $(this).find('.owl-item').not('.cloned').removeClass('animated zoomIn');
                    $(this).find('.owl-item.active').not('.cloned').addClass('animated zoomIn');
                },
            });
            console.log('Owl Carousel initialized:', $(carouselSlideContainer).data('owlCarousel'));
        } else {
            // No events scheduled
            carouselSlideContainer.innerHTML = '<p>No events scheduled for this date.</p>';
        }
    };
    // document.addEventListener('DOMContentLoaded', function() {
        // Get the current local date
        const currentDate = new Date();
        const currentDateString = currentDate.toLocaleString().split('T')[0];
        month_fetchMonthEvents(currentDateString).then(month_displayMonthEvents);
    // });
</script>


<div class="calendar">
    <div class="calendar-container">
        <div class="calendar-wrapper">
            <div class="calendar-header">
                <div class="month-head">
                    <button id="prevMonth"><i class="fa-solid fa-caret-left" ></i></button>
                    <div class="month" id="currentMonth"></div>
                    <button id="nextMonth"><i class="fa-solid fa-caret-right"></i></i></button>
                </div>
                <div class="year-head">
                    <button id="prevYear"><i class="fa-solid fa-caret-left"></i></i></button>
                    <div class="year" id="currentYear"></div>
                    <button id="nextYear"><i class="fa-solid fa-caret-right"></i></i></button>
                </div>
            </div>
            <div class="calendar-body">
                <div id="calendar">

                </div>
                <div class="events">
                    <h2>LIST OF EVENTS</h2>
                    <div id="carousel-container" class="owl-carousel owl-theme" style="border-radius:unset;"></div>
                    <div id="carouselSelect-container" class="owl-carousel owl-theme" style="border-radius:unset;"></div>
                    <a href="<?php echo $redirectURL; ?>"><button>Register</button></a>
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
    
    // Define the openMap function
    function openMap(id) {
        var mapUrl = 'http://192.168.18.39:5173/';
        if (id) {
            mapUrl += '?id=' + id;
        }
        window.open(mapUrl, '_blank');
    }

    // Function to fetch events from the server
    const daily_fetchDailyEvents = async (selectedDate) => {
        try {
            // Send an AJAX request to fetch events for the selected date
            const response = await fetch('fetch_events.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `selectedDate=${selectedDate}`,
            });const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching events:', error);
            return [];
        }
    };

    // Function to display events in the carousel
    // const daily_displayDailyEvents = (events) => {
    //     const carouselContainer = document.getElementById('carousel-container');
    //     if (events.length > 0) {
    //         // Clear existing content
    //         carouselContainer.innerHTML = '';

    //         // Iterate over events and create carousel items
    //         events.forEach(event => {
    //             const carouselItem = document.createElement('div');
    //             carouselItem.classList.add('carousel-item');
    //             carouselItem.innerHTML = `
    //                 <div class="event-preview">
    //                     <h3>${event.event_name}</h3>
    //                     <p><span>Event Code: </span> ${event.event_code}</p>
    //                     <p> <span>Duration:</span> ${event.start_from} - ${event.end_to}</p>
    //                     <p><span>Status: </span> ${event.event_status}</p>
    //                     <!-- Add other event details as needed -->
    //                     <div class="event-details">
    //                         <p><span>Event Purpose: </span><br> ${event.event_purpose}</p>
    //                         <p><span>Participants: </span> ${event.participants}</p>
    //                         <p><span>Host: </span> ${event.host_first_name} ${event.host_last_name}</p>
    //                         <p><span>Facility: </span> ${event.facility_name} - ${event.building_loc}</p>
    //                         <button class="navigate-button" onclick="openMap(${event.event_ID})">Navigate</button>
    //                         <!-- Add other event details as needed -->
    //                     </div>
    //                 </div>
    //             `;
    //             carouselContainer.appendChild(carouselItem);

    //             // Event listener to toggle event details on click
    //             carouselItem.addEventListener('click', () => {
    //                 const eventDetails = carouselItem.querySelector('.event-details');
    //                 eventDetails.classList.toggle('show');
    //             });
    //         });
    //         console.log('Carousel items appended:', carouselSlideContainer.innerHTML); 
    //         // Initialize Owl Carousel
    //         $(carouselContainer).owlCarousel({
    //             loop: true,
    //             margin: 5,
    //             autoplay: false,
    //             autoplayTimeout: 3000, // autoscroll every 5 seconds
    //             autoplayHoverPause: true, // pause autoplay on hover
    //             items: 1,
    //             center: true,
    //             dots: true, // show dots navigation
    //             nav: false, // show prev/next navigation
    //             //animateOut: 'fadeOut', // fade out animation
    //             //animateIn: 'fadeIn', // fade in animation
    //             smartSpeed: 500, // animation speed
    //             onTranslate: function() {
    //                 $(this).find('.owl-item').not('.cloned').removeClass('animated zoomIn');
    //                 $(this).find('.owl-item.active').not('.cloned').addClass('animated zoomIn');
    //             },
    //         }); 
    //         console.log('Owl Carousel initialized:', $(carouselSlideContainer).data('owlCarousel')); 
    //     } else {
    //         // No events scheduled
    //         carouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
    //     }
    // };
    const daily_displayDailyEvents = (events) => {
        const carouselContainer = document.getElementById('carousel-container');
        if (events.length > 0) {
            // Clear existing content
            carouselContainer.innerHTML = '';

            // Iterate over events and create carousel items
            events.forEach(event => {
                const carouselItem = document.createElement('div');
                carouselItem.classList.add('carousel-item');
                carouselItem.innerHTML = `
                    <div class="event-preview">
                        <h3>${event.event_name}</h3>
                        <p><span>Event Code: </span> ${event.event_code}</p>
                        <p> <span>Duration:</span> ${event.start_from} - ${event.end_to}</p>
                        <p><span>Status: </span> ${event.event_status}</p>
                        <!-- Add other event details as needed -->
                        <div class="event-details">
                            <p><span>Event Purpose: </span><br> ${event.event_purpose}</p>
                            <p><span>Participants: </span> ${event.participants}</p>
                            <p><span>Host: </span> ${event.host_first_name} ${event.host_last_name}</p>
                            <p><span>Facility: </span> ${event.facility_name} - ${event.building_loc}</p>
                            <button class="navigate-button" onclick="openMap(${event.event_ID})">Navigate</button>
                            <!-- Add other event details as needed -->
                        </div>
                    </div>
                `;
                carouselContainer.appendChild(carouselItem);

                // Event listener to toggle event details on click
                carouselItem.addEventListener('click', () => {
                    const eventDetails = carouselItem.querySelector('.event-details');
                    eventDetails.classList.toggle('show');
                });
            });

            // Destroy existing Owl Carousel instance (if any)
            if ($(carouselContainer).hasClass('owl-loaded')) {
                $(carouselContainer).owlCarousel('destroy');
            }

            // Initialize Owl Carousel
            $(carouselContainer).owlCarousel({
                loop: true,
                margin: 5,
                autoplay: false,
                autoplayTimeout: 3000, // autoscroll every 5 seconds
                autoplayHoverPause: true, // pause autoplay on hover
                items: 1,
                center: true,
                dots: true, // show dots navigation
                nav: false, // show prev/next navigation
                //animateOut: 'fadeOut', // fade out animation
                //animateIn: 'fadeIn', // fade in animation
                smartSpeed: 500, // animation speed
                onTranslate: function() {
                    $(this).find('.owl-item').not('.cloned').removeClass('animated zoomIn');
                    $(this).find('.owl-item.active').not('.cloned').addClass('animated zoomIn');
                },
            });

        } else {
            // No events scheduled
            carouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
        }
    };

    
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current local date
        const currentDate = new Date();
        const currentDateString = currentDate.toLocaleString().split('T')[0];
        daily_fetchDailyEvents(currentDateString).then(daily_displayDailyEvents);
    });

</script>    
<!-- <script src="script/daily_events.js"></script> -->
<script src="script/selected_events.js"></script>

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
        var currentDateTimeEl =document.getElementById('currentDateTime');

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
                fetchSelectedEvents(selectedDate.toLocaleString()).then(displaySelectedEvents); // Fetch events for selected date
            }
        });

        // Emphasize current date in the calendar
        function emphasizeCurrentDate() {var cells = document.querySelectorAll('#calendar td');
            cells.forEach(function(cell) {
                cell.classList.remove('current-date'); // Remove existing emphasis
                var date = new Date(cell.getAttribute('data-date'));
                if (date.getDate() === currentDay && date.getMonth() === currentMonth && date.getFullYear() === currentYear) {
                    cell.classList.add('current-date'); // Add emphasis to current date
                }
            });
        }

       
        // Function to fetch events from the server
        function fetchSelectedEvents(selectedDate) {
            // Return a new Promise that wraps the AJAX request
            return new Promise((resolve, reject) => {
                // Send a POST request to fetch_events.php with the selected date
                $.ajax({
                    url: 'fetch_events.php',
                    method: 'POST',
                    data: { selectedDate: selectedDate },
                    success: function(data) {
                        // Resolve the promise with the fetched data
                        resolve(data);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Reject the promise with the error
                        reject(errorThrown);
                    }
                });
            });
        }


        // Function to display events in the carousel
        const displaySelectedEvents = (events) => {
            const carouselContainer = document.getElementById('carousel-container');
            if (events.length > 0) {
                // Clear existing content
                carouselContainer.innerHTML = '';

                // Iterate over events and create carousel items
                events.forEach(event => {
                    const carouselItem = document.createElement('div');
                    carouselItem.classList.add('carousel-item');
                    carouselItem.innerHTML = `
                        <div class="event-preview">
                            <h3>${event.event_name}</h3>
                            <p><span>Event Code: </span> ${event.event_code}</p>
                            <p> <span>Duration:</span> ${event.start_from} - ${event.end_to}</p>
                            <p><span>Status: </span> ${event.event_status}</p>
                            <!-- Add other event details as needed -->
                            <div class="event-details">
                                <p><span>Event Purpose: </span><br> ${event.event_purpose}</p>
                                <p><span>Participants: </span> ${event.participants}</p>
                                <p><span>Host: </span> ${event.host_first_name} ${event.host_last_name}</p>
                                <p><span>Facility: </span> ${event.facility_name} - ${event.building_loc}</p>
                                <button class="navigate-button" onclick="openMap(${event.event_ID})">Navigate</button>
                                <!-- Add other event details as needed -->
                            </div>
                        </div>
                    `;
                    carouselContainer.appendChild(carouselItem);

                    // Event listener to toggle event details on click
                    carouselItem.addEventListener('click', () => {
                        const eventDetails = carouselItem.querySelector('.event-details');
                        eventDetails.classList.toggle('show');
                    });
                });

                // Destroy existing Owl Carousel instance (if any)
                if ($(carouselContainer).hasClass('owl-loaded')) {
                    $(carouselContainer).owlCarousel('destroy');
                }

                // Initialize Owl Carousel
                $(carouselContainer).owlCarousel({
                    loop: true,
                    margin: 5,
                    autoplay: false,
                    autoplayTimeout: 3000, // autoscroll every 5 seconds
                    autoplayHoverPause: true, // pause autoplay on hover
                    items: 1,
                    center: true,
                    dots: true, // show dots navigation
                    nav: false, // show prev/next navigation
                    //animateOut: 'fadeOut', // fade out animation
                    //animateIn: 'fadeIn', // fade in animation
                    smartSpeed: 500, // animation speed
                    onTranslate: function() {
                        $(this).find('.owl-item').not('.cloned').removeClass('animated zoomIn');
                        $(this).find('.owl-item.active').not('.cloned').addClass('animated zoomIn');
                    },
                }); 

            } else {
                // No events scheduled
                carouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
            }
        };

        


        // Call the fetchEvents function with the current date
        // const currentDate = new Date();
        // const currentDateString = currentDate.toLocaleString().split('T')[0];
        // fetchSelectedEvents(currentDateString).then(displaySelectedEvents);

        // Function to highlight dates with events
        function highlightDatesWithEvents(events) {
            console.log("Highlighting dates with events...");
            console.log("Events:", events);
            // Get all calendar cells
            var cells = document.querySelectorAll('#calendar td');
            // Loop through the events
            events.forEach(event => {
                // Get the date of the event
                const eventDate = new Date(event.start_from);
                console.log("event.start_from: ", event.start_from);
                // Extract the year, month, and day
                const year = eventDate.getFullYear();
                const month = eventDate.getMonth();
                const day = eventDate.getDate();
                console.log("year:", year);
                console.log("month:", month + 1);
                console.log("day:", day);

                // Get the corresponding table cell element for the event date
                const cell = document.querySelector(`#calendar td[data-date="${month + 1}/${day}/${year}"]`);

                console.log("cell: ", cell);
                console.log("cells length: ", cells.length);
                // Add a CSS class to highlight the date
                if (cell) {
                    cell.classList.add('highlighted-date');
                }
            });
        }

    });
</script>

<?php
    include('footer.php');
?>