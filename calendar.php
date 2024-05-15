<?php 

$pageTitle = "Calendar Dashboard";

include('header.php'); 

?>
<style>
  // .calendar{
  //   margin: 50px auto;
  //   .container{
  //     width: max-content;
  //     height: max-content;
  //     position: relative;
  //     display: flex;
  //     padding: 2% 0px 0px;
  //     justify-content: center;
  //     top: 10%;
  //     right: 0%;
  //     width: 100%;
  //     height: 100%;
  //     .calendar-wrapper{
  //       height: max-content;
  //       width: 30%;;
  //       background-color: white;
  //       border-radius: 25px;
  //       overflow: hidden;
  //       padding: 30px 50px 0px 50px;
  //       box-shadow: var(--shadow);
  //       .cal-bg-image {
  //         position: fixed;
  //         top: 0;
  //         left: 0;
  //         width: 100%;
  //         height: 100%;
  //         background-image: url('..static/image/red-spartan.png');
  //         background-size: cover;
  //         filter: blur(2px); 
  //         z-index: -1; 
  //       }
  //       .calendar-header{
  //         background: #9796f0;
  //         display: flex;
  //         justify-content: space-between;
  //         align-items: center;
  //         font-weight: 700;
  //         color: var(--white);
  //         padding: 10px;
  //         span.month-year{
  //           padding: 5px 10px;
  //           border-radius: 10px;
  //           cursor: pointer;
  //           font-size: 25px;
  //           font-weight: bold;
  //           &:hover{
  //             background-color: var(--color-hover);
  //             color: var(--color-text);
  //             cursor: pointer;
  //           }
  //         }
            
  //         .year-controls{
  //           display: flex;
  //           align-items: center;
  //           font-size: 20px;
  //           font-weight: bold;
  //           span.year-change{
  //             height: 30px;
  //             width: 30px;
  //             border-radius: 50%;
  //             display: grid;
  //             place-items: center;
  //             margin: 0px 0px;
  //             cursor: pointer;
  //             pre{
  //               margin-top: 0px;
  //               margin-bottom: 0px;
  //             }
  //             &:hover{
  //               background-color: var(--light-btn);
  //               transition: all .2s ease-in-out;
  //               transform: scale(1.12);
  //               pre{
  //                 color: var(--bg-body);
  //               }
  //             }
  //             #year:hover{
  //               cursor: pointer;
  //               transform: scale(1.2);
  //               transition: all 0.2 ease-in-out;
  //             }
  //           }  
              
  //         }

  //       }
  //       .calendar-body{
  //         pad: 10px;
  //         .calendar-week-days{
  //           display: grid;
  //           grid-template-columns: repeat(7, 1fr);
  //           font-weight: 600;
  //           cursor: pointer;
  //           color: rgb(104, 104, 104);
  //           div{
  //             display: grid;
  //             place-items: center;
  //             color: var(--bg-second);
  //             height: 50px;
  //             &:hover{
  //               color: black;
  //               transform: scale(1.2);
  //               transition: all .2s ease-in-out;
  //             }
  //           }
  //         }
  //         .calendar-days{
  //           display: grid; 
  //           grid-template-columns: repeat(7, 1fr);
  //           gap: 2px;
  //           color: var(--color-text);
  //           div{
  //             width: 37px;
  //             height: 33px;
  //             display: flex;
  //             align-items: center;
  //             justify-content: center;
  //             padding: 5px;
  //             position: relative;
  //             cursor: pointer;
  //             animation: to-top 1s forwards;
  //             span{
  //               position: absolute;
  //             }
  //             &:hover{
  //               transition: width 0.2s ease-in-out, height 0.2s ease-in-out;
  //               background-color: #fbc7d4;
  //               border-radius: 20%;
  //               color: var(--dark-text);
  //             }
  //           }
  //           div.current-date{
  //             color: var(--dark-text);
  //             background-color: var(--light-btn);
  //             border-radius: 20%;
  //           }
  //         }
  //       }
  //       .calendar-footer{
  //         padding: 10px;
  //         display: flex;
  //         justify-content: flex-end;
  //         align-items: center;
  //       }
  //       .month-list{
  //         position: relative;
  //         left: 0;
  //         top: -50px;
  //         background-color: transparent #040303;
  //         column-rule: var(--light-text);
  //         display: grid;
  //         grid-template-columns: repeat(3, auto);
  //         gap: 5px;
  //         border-radius: 20px;
  //         font-size: 18px;
  //         font-weight: bold;
  //         > div{
  //           display: grid;
  //           place-content: center;
  //           margin: 5px 10px;
  //           transition: all 0.2s ease-in-out;
  //           > div{
  //             border-radius: 15px;
  //             padding: 10px;
  //             cursor: pointer;
  //             &:hover{
  //               background-color: #fbc7d4;
  //               color: var(--dark-text);
  //               transform: scale(0.9);
  //               transition: all 0.2s ease-in-out;
  //             }
  //           }
  //         }
  //         &.show{
  //           visibility: visible;
  //           pointer-events: visible;
  //           transition: 0.6s ease-in-out;
  //           animation: to-left .71s forwards;
  //           margin-top: 3rem;
  //         }
  //         &.hideonce{
  //           visibility: hidden;
  //         }
  //         &.hide{
  //           animation: to-right 1s forwards;
  //           visibility: none;
  //           pointer-events: none;
  //         }
  //       }
        
        
  //       .date-time-formate{
  //         width: max-content;
  //         height: max-content;
  //         font-family: Dubai Light, Century Gothic;
  //         position: relative;
  //         display: inline;
  //         //top: 140px;
  //         top: 200px;
  //         justify-content: center;
  //         font-size: 18px;
  //         font-weight: bold;
  //         left: 1.5rem;
  //         .day-text-formate{
  //           font-family: Microsoft JhengHei UI;
  //           font-size: 1.4rem;
  //           padding-right: 5%;
  //           border-right: 3px solid #9796f0;
  //           position: absolute;
  //           left: 1.5rem;
  //           top: -65px;
  //           &.hidetime {
  //             animation: hidetime 1.5s forwards;
  //           }
  //           &.showtime{
  //             animation: showtime 1.5s forwards;
  //           }
  //         }


  //         .date-time-value{
  //           display: block;
  //           height: max-content;
  //           width: max-content;
  //           position: relative;
  //           left: 40%;
  //           top: -80px;
  //           text-align: center;
  //           .time-formate{
  //             font-size: 1.5rem; 
  //             &.hideTime{
  //               animation: hidetime 1.5s forwards;
  //             }
  //             &.showtime{
  //               animation: showtime 1.5s forwards;
  //             }
  //           }
            
  //           .date-formate.hideTime{
  //             animation: hidetime 1.5s forwards;
  //           }
  //           .date-formate.showtime{
  //             animation: showtime 1s forwards;

  //           }
  //         }
  //       }
  //     }
  //   }
  // }
  // @keyframes to-top {
  //   0% {
  //     transform: translateY(0);
  //     opacity: 0;
  //   }
  //   100% {
  //     transform: translateY(100%);
  //     opacity: 1;
  //   }
  // }

  // @keyframes to-left {
  //   0% {
  //     transform: translatex(230%);
  //     opacity: 1;
  //   }
  //   100% {
  //     transform: translatex(0);
  //     opacity: 1;
  //   }
  // }

  // @keyframes to-right {
  //   10% {
  //     transform: translatex(0);
  //     opacity: 1;
  //   }
  //   100% {
  //     transform: translatex(-150%);
  //     opacity: 1;
  //   }
  // }

  // @keyframes showtime {
  //   0% {
  //     transform: translatex(250%);
  //     opacity: 1;
  //   }
  //   100% {
  //     transform: translatex(0%);
  //     opacity: 1;
  //   }
  // }

  // @keyframes hidetime {
  //   0% {
  //     transform: translatex(0%);
  //     opacity: 1;
  //   }
  //   100% {
  //     transform: translatex(-370%);
  //     opacity: 1;
  //   }
  // }

  // @media (max-width: 375px) {
  //   .month-list > div {
  //     margin: 5px 0px;
  //   }
  // }
</style>

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