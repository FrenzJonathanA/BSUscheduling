
<?php 

$pageTitle = "Display of Events";

include('header.php'); 

?>

<!-- <div class="facility-icons">
    <a href=""><i class="fa-solid fa-dumbbell"></i></a>
    <a href=""><i class="fa-solid fa-record-vinyl"></i></a>
    <a href=""><i class="fa-solid fa-handshake-simple"></i></a>
    <a href=""><i class="fa-solid fa-dumbbell"></i></a>
    <a href=""><i class="fa-solid fa-record-vinyl"></i></a>
    <a href=""><i class="fa-solid fa-handshake-simple"></i></a>
    <a href=""><i class="fa-solid fa-dumbbell"></i></a>
    <a href=""><i class="fa-solid fa-record-vinyl"></i></a>
    <a href=""><i class="fa-solid fa-handshake-simple"></i></a>

</div> -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="scss/style.css"> 

    
    <div class="MonthlyEvents" style="margin-bottom: 50px;">
        <h2>Monthly Events</h2>
        <div id="carouselSlide-container" class="owl-carousel owl-theme" style="border-radius:unset;"></div>
        <a href="cal-sample.php"><button class="calendarView">View Calendar</button></a>
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
                    <div class="event-details" style="display: block;">
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
            console.log('Carousel items appended:', carouselSlideContainer.innerHTML); // Add a log statement to check the carousel items
            // Initialize Owl Carousel
            $(carouselSlideContainer).owlCarousel({
                loop: true,
                margin: 5,
                autoplay: true,
                autoplayTimeout: 3000, // autoscroll every 5 seconds
                responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                //1000: {
                //  items: 1
                //}
                },
                center: true,
                // animateOut: 'fadeOut',
                // animateIn: 'fadeIn',
                slideTransition: 'linear',
                smartSpeed: 500,
            });
            console.log('Owl Carousel initialized:', $(carouselSlideContainer).data('owlCarousel')); // Add a log statement to check if Owl Carousel is initialized
            } else {
            // No events scheduled
            carouselSlideContainer.innerHTML = '<p>No events scheduled for this date.</p>';
            }
        };

        // Get the current local date
        const currentDate = new Date();
        const currentDateString = currentDate.toLocaleString().split('T')[0];

        // Fetch events and display them in the carousel
        month_fetchMonthEvents(currentDateString).then(month_displayMonthEvents);
    </script>
    <style>
        .carouselSlide-item {
            transition: transform 0.5s ease-in-out;
            transform: scale(0.9);
        }
        .carouselSlide-item.active {
            transform: scale(1);
        }
        .carouselSlide-item.active + .carouselSlide-item,
        .carouselSlide-item.active + .carouselSlide-item + .carouselSlide-item {
            transform: scale(0.95);
            opacity: 0.8;
        }
    </style>

<?php 
    include('./footer.php'); 
    ?>
</body>

</html>

 