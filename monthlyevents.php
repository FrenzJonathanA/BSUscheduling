    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="scss/style.scss">
    
    <div class="MonthlyEvents">
        <h2>Monthly Events</h2>
        <div id="month_carousel-container" class="owl-carousel owl-theme"></div>
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
        function fetchEvents(selectedDate) {
            return new Promise(async (resolve, reject) => {
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
                    resolve(data);
                } catch (error) {
                    console.error('Error fetching events:', error);
                    reject(error);
                }
            });
        }

        // Function to display events in the carousel
        function displayEvents(events) {
            const month_carouselContainer = document.getElementById('month_carousel-container');
            if (events.length > 0) {
                // Clear existing content
                month_carouselContainer.innerHTML = '';

                // Iterate over events and create carousel items
                events.forEach((event) => {
                    const month_carouselItem = document.createElement('div');
                    month_carouselItem.classList.add('month_carousel-item');
                    month_carouselItem.innerHTML = `
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
                    month_carouselContainer.appendChild(month_carouselItem);

                    // Event listener to toggle event details on click
                    month_carouselItem.addEventListener('click', () => {
                        const eventDetails = month_carouselItem.querySelector('.event-details');
                        eventDetails.classList.toggle('show');
                    });
                });
                console.log('Carousel items appended:', month_carouselContainer.innerHTML); // Add a log statement to check the carousel items
                // Initialize Owl Carousel
                $(month_carouselContainer).owlCarousel({
                    loop: true,
                    margin: 5,
                    autoplay: true,
                    autoplayTimeout: 3000, // autoscroll every 5 seconds
                    autoplayHoverPause: true, // pause autoplay on hover
                    items: 1,
                    center: true,
                    dots: false, // show dots navigation
                    nav: false, // show prev/next navigation
                    //animateOut: 'fadeOut', // fade out animation
                    //animateIn: 'fadeIn', // fade in animation
                    smartSpeed: 500, // animation speed
                    onTranslate: function() {
                        $(this).find('.owl-item').not('.cloned').removeClass('animated zoomIn');
                        $(this).find('.owl-item.active').not('.cloned').addClass('animated zoomIn');
                    },
                });
                console.log('Owl Carousel initialized:', $(month_carouselContainer).data('owlCarousel')); // Add a log statement to check if Owl Carousel is initialized
            } else {
                // No events scheduled
                month_carouselContainer.innerHTML = '<p>No events scheduled for this date.</p>';
            }
        }

        // Get the current local date
        const currentDate = new Date();
        const currentDateString = currentDate.toISOString().split('T')[0];

        // Fetch events and display them in the carousel
        fetchEvents(currentDateString).then(displayEvents);
    </script>

