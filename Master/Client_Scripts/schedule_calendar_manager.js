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

        dayClick: function (date, allDay, jsEvent, view) {
            // Date object, need to increment day to get the right one
            selectedDate = date._d;
            selectedDate.setDate(selectedDate.getDate() + 1);
            selectedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1) + '-' + selectedDate.getDate();

            $('#eventModal').modal('show');

        },

        loading: function (bool) {
            $('#loading').toggle(bool);
        }

    });

    // Modal Validator
    $('#eventModal').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            eventName: {
                validators: {
                    notEmpty: {
                        message: 'The event name is required'
                    }
                }
            },
        }
    });

    /*$('#addEventModalForm').on("submit", function (event) {
        event.preventDefault();
        if($('#eventName').val() == "")
        {
            alert("Name is required");
        }
        else if($('#eventStart').val() == '')
        {
            alert("Address is required");
        }
        else if($('#eventEnd').val() == '')
        {
            alert("Designation is required");
        }
    });*/
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

$('#eventModal').on('shown.bs.modal', function() {
    $('#eventModal').bootstrapValidator('resetForm', true);
});

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

$(function(){
    $('#addEventModalForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "../../EmployeeManager/Master/Server_Scripts/ScheduleManager.php", //this is the submit URL
            type: 'POST', //or POST
            /*data: $('#addEventModalForm').serialize(),
            success: function(data){
                alert('successfully submitted')
            }*/
        });
    });
});