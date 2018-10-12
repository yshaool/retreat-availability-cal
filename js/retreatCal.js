function showAvailability(onlyPending){  
    cleanAllCells();
    //start_date id end_date status first_name last_name full_name room_id (6)
    for (var i = 0, len = registrations.length; i < len; i++) 
    {          
        if (registrations[i]["room_id"]!=roomID) continue;

        if (onlyPending && registrations[i]["status"]!="pending") continue;

        if ($("#"+registrations[i]["start_date"]).length)
        {
            if ($("#"+registrations[i]["start_date"]).data( "selected"))
            {
               $("#"+registrations[i]["start_date"]).addClass("registeredCallendarCellDouble");                                         
               $("#"+registrations[i]["start_date"]).attr( "data-toggle", "tooltip");   
               $("#"+registrations[i]["start_date"]).attr( "data-placement", "top");   
               $("#"+registrations[i]["start_date"]).attr( "title",$("#"+registrations[i]["start_date"]).attr("title")+"+"+registrations[i]["full_name"]);
           }
            else
            {
              $("#"+registrations[i]["start_date"]).addClass("registeredCallendarCell");
              $("#"+registrations[i]["start_date"]).data( "selected", true);   
              $("#"+registrations[i]["start_date"]).attr( "data-toggle", "tooltip");   
              $("#"+registrations[i]["start_date"]).attr( "data-placement", "top");   
              $("#"+registrations[i]["start_date"]).attr( "title",registrations[i]["full_name"]); 
              availableDays=availableDays-1;
              selectedDays.push($("#"+registrations[i]["start_date"]));
            }
         }

         var currentDay = new Date(registrations[i]["start_date"]);
         currentDay.setDate(currentDay.getDate()+1);//fixed for today

         $numberOfNights=parseInt(registrations[i]["nights"]);
         for (var j=1;j<$numberOfNights;j++)
         {
             currentDay.setDate(currentDay.getDate()+1);//tomorrow
             //console.log(currentDay.toString());
             var y=currentDay.getFullYear();
             var m=currentDay.getMonth()+1;
             var monthStr=m.toString();
             if (m<10)monthStr="0"+monthStr;
             var d=currentDay.getDate();
             var dayStr=d.toString();
             if (d<10) dayStr="0" +dayStr;

             var nextDay=y.toString()+"-"+monthStr+"-"+dayStr;
             //console.log(nextDay);
             if ($("#"+nextDay).length)
             {
                if ($("#"+nextDay).data( "selected"))
                {
                   $("#"+nextDay).addClass("registeredCallendarCellDouble");                                         
                }
                else
                {
                  $("#"+nextDay).addClass("registeredCallendarCell");
                  $("#"+nextDay).data( "selected", true);
                  $("#"+nextDay).attr( "data-toggle", "tooltip");   
                  $("#"+nextDay).attr( "data-placement", "top");   
                  $("#"+nextDay).attr( "title",registrations[i]["full_name"]); 
                  availableDays=availableDays-1;
                  selectedDays.push($("#"+nextDay));
                }
             }
          }

        //console.log(registrations[i]["start_date"]);
        //console.log(registrations[i]["end_date"]);
        //console.log("nights:"+registrations[i]["nights"]);
        //console.log(registrations[i]["room_id"]);
        //console.log(registrations[i]["id"]);
    }
    $("#numDaysAvailable").html(availableDays.toString()+" Available days.");
    $('[data-toggle="tooltip"]').tooltip({animated: 'fade',placement: 'top',});
}

function cleanAllCells()
{
    for (var i = 0, len = selectedDays.length; i < len; i++) 
    { 
        var cellToRemove=selectedDays.pop();
        cellToRemove.removeClass( "registeredCallendarCell registeredCallendarCellDouble" );
        cellToRemove.data( "selected", false);
        cellToRemove.attr( "data-toggle", "");   
        cellToRemove.attr( "data-placement", "");   
        cellToRemove.attr( "title",""); 
        availableDays=availableDays+1;        
    }

}