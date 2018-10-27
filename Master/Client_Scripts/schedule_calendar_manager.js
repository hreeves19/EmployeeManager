var selectedDate = "";

$(document).ready(function() {

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
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,

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

        dayClick: function (date, allDay, jsEvent, view) {
            // Date object, need to increment day to get the right one
            // It is off by 5 hours, so we are adding 5 hours
            var time = date._d;
            time.setHours(time.getHours() + 5); //HH:mm
            selectedDate = date._d;
            selectedDate.setDate(selectedDate.getDate() + 1);
            selectedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1) + '-' + selectedDate.getDate();
            document.getElementById("date").value = selectedDate;

            if(ismanger)
            {
                $('#eventModal').modal('show');
            }
        },

        loading: function (bool) {
            $('#loading').toggle(bool);
        },

        select: function(start, end)
        {
            console.log(start);
        },

        eventClick: function(calEvent, jsEvent, view) {
            // Need start and end
            // Need id
            // _d for date
            console.log(calEvent);
            console.log(jsEvent);
            console.log(view);
            console.log(calEvent.start._d.getDate());
            var day = calEvent.start._d.getDate();

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
    $('#editModal').on('hidden.bs.modal', function() {
        $('#editModal').bootstrapValidator('resetForm', true);
    });

    // Modal Validator
    $('#btnSubmit').click(function() {
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
    });
});

