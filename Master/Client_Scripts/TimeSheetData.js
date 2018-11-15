var selectedDate = "";
var startDate ="";
var endDate = "";
var eventid = -1;
var dayClicked = false;

$(document).ready(function() {

    moment().tz("America/Chicago").format();

    // Getting today's current date
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    $('#calendar').fullCalendar
    ({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
        defaultView: "agendaWeek",
        defaultDate: date,
        timezone: "American/Chicago",
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        allDay: false,

        eventSources: [
            {
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '../../EmployeeManager/Master/Server_Scripts/TimeSheetData.php', //server script
                        dataType: 'json',
                        data: {
                            // our hypothetical feed requires UNIX timestamps
                            start: start.unix(),
                            end: end.unix()
                        },
                        success: function(msg) {
                            console.log(msg);
                            var events = msg.events;
                            callback(events);
                        }
                    });
                }
            },
        ],

        dayClick: function (date, jsEvent, view) {
            // Date object, need to increment day to get the right one
            // It is off by 5 hours, so we are adding 5 hours
            console.log(date.format());
        },

        eventClick: function(calEvent, jsEvent, view) {
            // Need start and end
            // Need id
            // _d for date
            // YYYY-MM-DD
            console.log(calEvent);
            console.log(jsEvent);
            console.log(view);


            }
    });
});

