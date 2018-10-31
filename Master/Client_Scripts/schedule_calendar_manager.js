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
            var startArray;
            var endArray;
            var eDate;
            var sDate;

            // Seeing if there is a time
            var sTime = start.format().match(/T\d\d:\d\d:\d\d/);
            var eTime = end.format().match(/T\d\d:\d\d:\d\d/);

            if(sTime !== null && eTime !== null)
            {
                tempS = tempS.replace(/T\d\d:\d\d:\d\d/, "");
                tempE = tempE.replace(/T\d\d:\d\d:\d\d/, "");
                sTime = sTime[0].replace(/T/, "");
                eTime = eTime[0].replace(/T/, "");

                // Put it in an array
                sTime = sTime.split(":");
                eTime = eTime.split(":");

                // Getting date format
                startArray = tempS.split("-");
                endArray = tempE.split("-");

                // Creating date objects, this is if user selects the week
                sDate = new Date(parseInt(startArray[0]), parseInt(startArray[1]) - 1, parseInt(startArray[2]),
                    parseInt(sTime[0]), parseInt(sTime[1]), parseInt(sTime[2]), 0);
                eDate = new Date(parseInt(endArray[0]), parseInt(endArray[1]) - 1, parseInt(endArray[2]),
                    parseInt(eTime[0]), parseInt(eTime[1]), parseInt(eTime[2]), 0);

                console.log(sDate.getHours() + ":" + sDate.getMinutes());

                // For start time
                if(sDate.getHours() <= 9)
                {
                    if(sDate.getMinutes() <= 9)
                    {
                        // h:m
                        // Setting time
                        document.getElementById("eventStartSelect").value = "0" + sDate.getHours() + ":" + "0" + sDate.getMinutes();
                    }

                    else
                    {
                        //h:mm
                        // Setting time
                        document.getElementById("eventStartSelect").value = "0" + sDate.getHours() + ":" + sDate.getMinutes();
                    }
                }

                else
                {
                    if(sDate.getMinutes() <= 9)
                    {
                        // hh:m
                        // Setting time
                        document.getElementById("eventStartSelect").value = sDate.getHours() + ":" + "0" + sDate.getMinutes();
                    }

                    else
                    {
                        // hh:mm
                        // Setting time
                        document.getElementById("eventStartSelect").value = sDate.getHours() + ":" + sDate.getMinutes();
                    }
                }

                // For end time
                if(eDate.getHours() <= 9)
                {
                    if(eDate.getMinutes() <= 9)
                    {
                        // h:m
                        // Setting time
                        document.getElementById("eventEndSelect").value = "0" + eDate.getHours() + ":" + "0" + eDate.getMinutes();
                    }

                    else
                    {
                        //h:mm
                        // Setting time
                        document.getElementById("eventEndSelect").value = "0" + eDate.getHours() + ":" + eDate.getMinutes();
                    }
                }

                else
                {
                    if(eDate.getMinutes() <= 9)
                    {
                        // hh:m
                        // Setting time
                        document.getElementById("eventEndSelect").value = eDate.getHours() + ":" + "0" + eDate.getMinutes();
                    }

                    else
                    {
                        // hh:mm
                        // Setting time
                        document.getElementById("eventEndSelect").value = eDate.getHours() + ":" + eDate.getMinutes();
                    }
                }
            }

            else
            {
                // Getting date format
                startArray = tempS.split("-");
                endArray = tempE.split("-");

                sDate = new Date(parseInt(startArray[0]), parseInt(startArray[1]) - 1, parseInt(startArray[2]), 0, 0, 0, 0);
                eDate = new Date(parseInt(endArray[0]), parseInt(endArray[1]) - 1, parseInt(endArray[2]) - 1, 0, 0, 0, 0);
            }

            console.log(sDate);
            console.log(eDate);
            console.log(sTime);
            console.log(eTime);

            startDate = sDate.getFullYear() + '-' + (sDate.getMonth() + 1) + '-' + sDate.getDate();
            document.getElementById("dateSelectStart").value = startDate;
            endDate = eDate.getFullYear() + '-' + (eDate.getMonth() + 1) + '-' + eDate.getDate();
            document.getElementById("dateSelectEnd").value = endDate;

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
            document.getElementById("dateEditStart").value = startArray[0];
            document.getElementById("dateEditEnd").value = endArray[0];
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

            else
            {
                // Setting modal paragraphs
                document.getElementById("descTitle").innerHTML = calEvent.title;
                document.getElementById("textDescription").innerHTML = "<b>Description:</b> " + calEvent.description;
                document.getElementById("textStart").innerHTML = "<b>Event Starts:</b> " + startArray[0] + " at " + startArray[1];
                document.getElementById("textEnd").innerHTML = "<b>Event Ends:</b> " + endArray[0] + " at " + endArray[1];
                /*document.getElementById("textManager").innerHTML = "<b>Manager Name: </b>";*/

                if(parseInt(calEvent.mandatory) === 1)
                {
                    document.getElementById("textMandatory").innerHTML = "<b>Mandatory: </b>Yes";
                }

                else
                {
                    document.getElementById("textMandatory").innerHTML = "<b>Mandatory: </b>No";
                }

                // Show description
                $('#modalDescription').modal('show');
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
    $('#btnSubmitEdit').click(function() {
        var eventName = $('#eventNameEdit').val();
        var eventStart = $('#eventStartEdit').val();
        var eventEnd = $('#eventEndEdit').val();
        var mandatory = $('#mandatoryEdit').val();
        var eventDescription = $('#eventDescriptionEdit').val();
        var people = $('#peopleTaggedEdit').val();
        var selectedDate = $('#dateEditStart').val();
        var endDate = $('#dateEditEnd').val();
        console.log(eventid);

        if(eventName !== "" && eventStart !== "" && eventEnd !== "" && mandatory !== "" && eventDescription !== "" && people !== "" && eventid !== -1)
        {
            $.ajax({
                url: "../../EmployeeManager/Master/Server_Scripts/UpdateEvent.php",
                method:"POST",
                data:{eventName:eventName, eventStart:eventStart, eventEnd:eventEnd, mandatory:mandatory, eventDescription:eventDescription, people:people, selectedDate:selectedDate, eventid:eventid, endDate:endDate},
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
                    $('#eventModalSelect').modal('hide');
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            });
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

