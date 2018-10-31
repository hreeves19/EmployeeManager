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
    var ismanger = false;

    // Getting the managers id, if its -1 then this is a manager
    /*var manager_id = JSON.parse(document.getElementById("managerid").value);
    manager_id = parseInt(manager_id["dept_manager_id"]);*/

    var manager_id = document.getElementById("managerid").value;
    manager_id = parseInt(manager_id);
    console.log("Is manager: " + document.getElementById("managerid").value);

    if(manager_id === 0)
    {
        ismanger = true;
    }

    $('#calendar').fullCalendar
    ({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
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
                        url: '../../EmployeeManager/Master/Server_Scripts/UpdateCalendar.php',
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

        loading: function (bool) {
            $('#loading').toggle(bool);
        },

        select: function(start, end)
        {
            console.log(start.format());
            console.log(end.format());
            var tempS = start.format();
            var tempE = end.format();

            // Seeing if there is a time
            var sTime = start.format().match(/T\d\d:\d\d:\d\d/);
            var eTime = end.format().match(/T\d\d:\d\d:\d\d/);

            if(sTime !== null && eTime !== null)

            // Getting date format
            var startArray = tempS.split("-");
            var endArray = tempE.split("-");

            var sDate = new Date(parseInt(startArray[0]), parseInt(startArray[1]) - 1, parseInt(startArray[2]), 0, 0, 0, 0);
            var eDate = new Date(parseInt(endArray[0]), parseInt(endArray[1]) - 1, parseInt(endArray[2]) - 1, 0, 0, 0, 0);
            console.log(sDate);
            console.log(eDate);
            console.log(sTime);
            console.log(eTime);

            // Date object, need to increment day to get the right one
            // It is off by 5 hours, so we are adding 5 hours
            /*var sDate = start._d;
            var eDate = end._d;
            sDate.setHours(sDate.getHours()); //HH:mm
            startDate = start._d;
            startDate.setDate(startDate.getDate() + 1);
            startDate = startDate.getFullYear() + '-' + (startDate.getMonth() + 1) + '-' + startDate.getDate();
            document.getElementById("dateSelectStart").value = startDate;

            // End date
            endDate = end._d;
            endDate.setDate(endDate.getDate());
            endDate = endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + endDate.getDate();
            document.getElementById("dateSelectEnd").value = endDate;
            console.log(endDate);*/

            if(ismanger)
            {
                var show = $('#eventModal').hasClass('in');
                if(!show)
                {
                    $('#eventModalSelect').modal('show');
                }
            }
        },

        eventClick: function(calEvent, jsEvent, view) {
            // Need start and end
            // Need id
            // _d for date
            // YYYY-MM-DD
            console.log(calEvent);
            console.log(jsEvent);
            console.log(view);

            // title
            var day = calEvent.start._d.getDate();
            var startDate = calEvent.start._d.getUTCFullYear() + "-" + (calEvent.start._d.getUTCMonth() + 1) + "-" + calEvent.start._d.getUTCDay();
            var endDate = calEvent.end._d.getUTCFullYear() + "-" + (calEvent.end._d.getUTCMonth() + 1) + "-" + calEvent.end._d.getUTCDay();
            var startArray = calEvent.start._i.split(" ");
            var endArray = calEvent.end._i.split(" ");
            document.getElementById("dateEdit").value = startArray[0];
            document.getElementById("eventNameEdit").value = calEvent.title;
            document.getElementById("eventStartEdit").value = startArray[1];
            document.getElementById("eventEndEdit").value = endArray[1];
            document.getElementById("eventDescriptionEdit").value = calEvent.description;
            eventid = calEvent.id;
            $('#mandatoryEdit').val(calEvent.mandatory);

            if(ismanger)
            {
                $('#editModal').modal('show');
            }
        }
    });

    // Keeps modal showing
    $('#eventModal').on('hidden.bs.modal', function() {
        $('#eventModal').bootstrapValidator('resetForm', true);
    });

    // Keeps modal showing
    $('#eventModalSelect').on('hidden.bs.modal', function() {
        $('#eventModalSelect').bootstrapValidator('resetForm', true);
    });

    // Keeps modal showing
    $('#editModal').on('hidden.bs.modal', function() {
        $('#editModal').bootstrapValidator('resetForm', true);
    });

    // Modal Validator
/*    $('#btnSubmit').click(function() {
        var eventName = $('#eventName').val();
        var eventStart = $('#eventStart').val();
        var eventEnd = $('#eventEnd').val();
        var mandatory = $('#mandatory').val();
        var eventDescription = $('#eventDescription').val();
        var people = $('#peopleTagged').val();
        var selectedDate = $('#date').val();

        if(eventName !== "" && eventStart !== "" && eventEnd !== "" && mandatory !== "" && eventDescription !== "" && people !== "")
        {
            $.ajax({
                url: "../../EmployeeManager/Master/Server_Scripts/ScheduleManager.php",
                method:"POST",
                data:{eventName:eventName, eventStart:eventStart, eventEnd:eventEnd, mandatory:mandatory, eventDescription:eventDescription, people:people, selectedDate:selectedDate},
                success:function(data)
                {

                }
            });

            // Force body to reload
            $('body').click(function() {
                location.reload();
            });
        }
    });*/

    // Modal Validator
    $('#btnSubmitEdit').click(function() {
        var eventName = $('#eventNameEdit').val();
        var eventStart = $('#eventStartEdit').val();
        var eventEnd = $('#eventEndEdit').val();
        var mandatory = $('#mandatoryEdit').val();
        var eventDescription = $('#eventDescriptionEdit').val();
        var people = $('#peopleTaggedEdit').val();
        var selectedDate = $('#dateEdit').val();
        console.log(eventid);

        if(eventName !== "" && eventStart !== "" && eventEnd !== "" && mandatory !== "" && eventDescription !== "" && people !== "" && eventid !== -1)
        {
            $.ajax({
                url: "../../EmployeeManager/Master/Server_Scripts/UpdateEvent.php",
                method:"POST",
                data:{eventName:eventName, eventStart:eventStart, eventEnd:eventEnd, mandatory:mandatory, eventDescription:eventDescription, people:people, selectedDate:selectedDate, eventid:eventid},
                success:function(data)
                {
                    console.log(data);
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            });
        }
    });

    // Modal Validator
    $('#btnSubmitSelect').click(function() {
        var eventName = $('#eventNameSelect').val();
        var eventStart = $('#eventStartSelect').val();
        var eventEnd = $('#eventEndSelect').val();
        var mandatory = $('#mandatorySelect').val();
        var eventDescription = $('#eventDescriptionSelect').val();
        var people = $('#peopleTagged').val();
        var selectedDateStart = $('#dateSelectStart').val();
        var selectedDateEnd = $('#dateSelectEnd').val();

        if(eventName !== "" && eventStart !== "" && eventEnd !== "" && mandatory !== "" && eventDescription !== "" && people !== "")
        {
            $.ajax({
                url: "../../EmployeeManager/Master/Server_Scripts/ScheduleManager.php",
                method:"POST",
                data:{eventName:eventName, eventStart:eventStart, eventEnd:eventEnd, mandatory:mandatory, eventDescription:eventDescription, people:people, selectedDate:startDate, selectedDateEnd:endDate},
                success:function(data)
                {
                    /*$('#calendar').fullCalendar( ‘refetchEvents’ );*/

                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            });

            // Force body to reload
            /*$('body').click(function() {
                location.reload();
            });*/
        }
    });

    // Modal Validator
    $('#btnDeleteEvent').click(function() {
        console.log(eventid);

        if(eventid !== -1)
        {
            $.ajax({
                url: "../../EmployeeManager/Master/Server_Scripts/UpdateEvent.php",
                method:"POST",
                data:{eventid:eventid, delete:true},
                success:function(data)
                {
                    console.log(data);
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            });
        }
    });
});

