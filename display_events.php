
<?php 

$pageTitle = "Display of Events";

include('header.php'); 

?>
    <style>
        /* CSS for the carousel container */
        #carousel-container {
            width: 80%;
            margin: 0 auto;
            min-height: 69vh;
        }

        /* CSS for individual carousel items */
        .carousel-item {
            background-color: #f0f0f0;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            cursor: pointer; /* Change cursor to pointer when hovering over carousel items */
            max-width: 60%;
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
    include('./footer.php'); 
    ?>
</body>

</html>

 