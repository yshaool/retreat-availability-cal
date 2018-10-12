<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Retreat Availability Calendar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/retreatCal.css" rel="stylesheet">
    
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="#">Retreat Availability Calendar </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="text-center">
          <h1>Retreat Availability Calendar</h1> 
        </div>
        <div class="container"> 
        <?
        $date = new DateTime("2025-08-01");
        $time=$date->getTimestamp();

        $numDay = date('d', $time);
        $numMonth = date('m', $time);
        $strMonth = date('F', $time);
        $numYear = date('Y', $time);
        $firstDay = mktime(0,0,0,$numMonth,1,$numYear);
        $daysInMonth = cal_days_in_month(0, $numMonth, $numYear);
        $dayOfWeek = date('w', $firstDay);
        ?>
                 
        <div class="container callendar">
            <div class="row">
             <div class="col-2"><label class="switch"><input id="pendingSwitch" type="checkbox"><span class="slider round"></span></label> </div>
             <div class="col-5" style="text-align:left;">Show only pending registrations</div>
             <div class="col-5"><h3 class="monthYear"><? echo($strMonth); ?> -<? echo($numYear); ?></div>
            </div>

            <div class="row">
              <div class="col calendarCell CellTitle">Sunday</div>
              <div class="col calendarCell CellTitle">Monday</div>
              <div class="col calendarCell CellTitle ">Tuesday</div>
              <div class="col calendarCell CellTitle">Wednesday</div>
              <div class="col calendarCell CellTitle">Thursday</div>
              <div class="col calendarCell CellTitle">Friday</div>
              <div class="col calendarCell CellTitle">Saturday</div>
            </div>

        <div class="row">
        <?
        //adding empty cells for week days from last month
        if ($dayOfWeek!=0){
            for ($j=0;$j<$dayOfWeek;$j++)
            {
                ?><div class="col calendarCell"></div><?
            }
        }
        $j=0;
        for($i=1;$i<=$daysInMonth;$i++) {
            $dayStr=$i;
            if ($i<10) $dayStr="0".$i;   
            ?><div class="col calendarCell"  id="<? echo $numYear."-".$numMonth."-".$dayStr ?>"><? echo($i); ?></div><?
            if (date('w', mktime(0,0,0,$numMonth, $i, $numYear)) == 6) 
            {
                ?></div><div class="row"><?
                $j=0;
            }
            $j++;
        }
        //adding empty cells for week days from next month
        if ($j<8){
            for ($j;$j<8;$j++)
            {
                ?><div class="col calendarCell"></div><?
            }
        }
        ?>
        </div>
         <br>
         <div id="numDaysAvailable" class="availableDays"></div>           
        </div>
     </div>       
    </div>
    
    <br><br>
    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="js/retreatCal.js"></script>

    <script>
    var registrations; //will hold registration array from JSON
    var roomID="6"; // hard coded for now for the room that we want (room 5 is room id 6)
    var availableDays=<? echo $daysInMonth ?>; //starting how many days in the month (will be changed by showAvailability
    var selectedDays=[]; //array of ordered days elements
   
    
    var jqxhr = $.getJSON("https://demo14.secure.retreat.guru/api/v1/registrations?token=ef061e1a717568ee5ca5c76a94cf5842", function(data) {
        registrations=data;
        showAvailability(false);
    })
      .fail(function() {
        console.log( "An error occured with the API");
    });

    //--switch between pending only and all
    $('#pendingSwitch').change(function() {
      //console.log('Toggle: ' + $(this).prop('checked'));     
      showAvailability($(this).prop('checked'));
    });
 
    </script>
  </body>
</html>
