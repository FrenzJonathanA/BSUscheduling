<?php 

$pageTitle = "Calendar Dashboard";

include('header.php'); 

?>


  <div class="calendar">
    <div class="container">
      <div class="cal-wrapper">
        <div class="cal-bg-image"></div>
        <div class="calendar-header">
          <span class="month-picker" id="month-picker"> May </span>
          <div class="year-picker" id="year-picker">
            <span class="year-change" id="pre-year">
              <pre><</pre>
            </span>
            <span id="year">2020 </span>
            <span class="year-change" id="next-year">
              <pre>></pre>
            </span>
          </div>
        </div>
  
        <div class="calendar-body">
          <div class="calendar-week-days">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
          </div>
          <div class="calendar-days">
          </div>
        </div>
        <div class="calendar-footer">
        </div>
        <div class="date-time-formate">
          <div class="day-text-formate">TODAY</div>
          <div class="date-time-value">
            <div class="time-formate">02:51:20</div>
            <div class="date-formate">23 - july - 2022</div>
          </div>
        </div>
        <div class="month-list"></div>
      </div>
      <!-- Events container -->
      <div class="events-container" id="eventDetailsTableContainer"></div>
    </div>
  </div>

<?php 

include('footer.php'); 

?>
<script>
  // Function to fetch event details based on event code
  function fetchEventDetails(eventCode) {
      fetch('search.php?event_code=' + eventCode)
      .then(response => response.json())
      .then(data => {
          if (!data.error) {
              // If data is retrieved successfully, create HTML table to display event details
              let tableHtml = '<table border="1"><tr><th>Event Code</th><th>Event Name</th><th>Start Time</th><th>End Time</th><th>Status</th><th>Facility Code</th></tr>';
              data.forEach(event => {
                  tableHtml += '<tr>';
                  tableHtml += '<td>' + event.event_code + '</td>';
                  tableHtml += '<td>' + event.event_name + '</td>';
                  tableHtml += '<td>' + event.start_from + '</td>';
                  tableHtml += '<td>' + event.end_to + '</td>';
                  tableHtml += '<td>' + event.event_status + '</td>';
                  tableHtml += '<td>' + event.facility_code + '</td>';
                  tableHtml += '</tr>';
              });
              tableHtml += '</table>';

              // Display the table in the container
              document.getElementById('eventDetailsTableContainer').innerHTML = tableHtml;
          } else {
              // If there's an error, display the error message
              document.getElementById('eventDetailsTableContainer').innerHTML = 'Error: ' + data.error;
          }
      })
      .catch(error => {
          // If there's an error with the fetch request, display an error message
          document.getElementById('eventDetailsTableContainer').innerHTML = 'Error fetching data.';
      });
  }

  // Example: Fetch event details based on event code 'SCH1711935431'
  // fetchEventDetails('SCH1711935431');

</script>

</body>
</html>