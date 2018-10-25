var selectedDate = "";

$(document).ready(function() {

    // Getting today's current date
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    console.log(date);

    $('#calendar').fullCalendar
    ({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
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
                            var events = msg.events;
                            callback(events);
                        }
                    });
                }
            },
        ],

        dayClick: function (date, allDay, jsEvent, view) {
            // Date object, need to increment day to get the right one
            selectedDate = date._d;
            selectedDate.setDate(selectedDate.getDate() + 1);
            selectedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1) + '-' + selectedDate.getDate();
            document.getElementById("date").value = selectedDate;
            $('#eventModal').modal('show');

        },

        loading: function (bool) {
            $('#loading').toggle(bool);
        }

    });

    // Keeps modal showing
    $('#eventModal').on('hidden.bs.modal', function() {
        $('#eventModal').bootstrapValidator('resetForm', true);
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
            /*alert("Success!");*/
            /*console.log(selectedDate);*/

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

function addEvent()
{
    var eventName = document.getElementById("eventName").value;
    var eventStart = document.getElementById("eventStart").value;
    var eventEnd = document.getElementById("eventEnd").value;
    var mandatory = document.getElementById("mandatory");
    mandatory = mandatory.options [mandatory.selectedIndex] .value;

    /*if(eventName !== "")
    {
        console.log(mandatory);
    }

    else
    {
        alert("All fields must be filled.");
    }*/
}

/*
$(function() {

    $("#addEventModalForm").validate({
        rules: {
            pName: {
                required: true,
                minlength: 8
            },
            action: "required"
        },
        messages: {
            pName: {
                required: "Please enter some data",
                minlength: "Your data must be at least 8 characters"
            },
            action: "Please provide some data"
        }
    });
});*/

/*
$(function(){
    $('#addEventModalForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "../../EmployeeManager/Master/Server_Scripts/ScheduleManager.php", //this is the submit URL
            type: 'POST', //or POST
            /!*data: $('#addEventModalForm').serialize(),
            success: function(data){
                alert('successfully submitted')
            }*!/
        });
    });
});*/
