var employee = [];
var timesheet = [];

$(document).ready(function(){
        showTable();
        getEmployees();
    });

function getEmployees()
{
    $.ajax({
        url: "../../EmployeeManager/Master/Server_Scripts/ManageEmployeesManager.php",
        method: "post",
        data: {getEmployees: true},
        success:function(data)
        {
            data = JSON.parse(data);

            // Looping through the array of employees
            for(var i = 0; i < data.length; i++)
            {
                //console.log(data[i]);
                employee[i] = data[i];
                console.log(calculateChart(employee));
            }

            //console.log(timesheet);
            // Call calendar
            showCalendar();
        }
    });
}

function showCalendar()
{
    console.log(employee);

    // Getting today's current date
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'listDay,listWeek,month'
        },

        // customize the button names,
        // otherwise they'd all just say "list"
        views: {
            listDay: { buttonText: 'list day' },
            listWeek: { buttonText: 'list week' }
        },

        defaultView: 'listWeek',
        defaultDate: date,
        navLinks: true, // can click day/week names to navigate views
        eventSources: [
            {
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '../../EmployeeManager/Master/Server_Scripts/CalendarTimesheet.php',
                        dataType: 'json',
                        data: {
                            // our hypothetical feed requires UNIX timestamps
                            start: start.unix(),
                            end: end.unix()
                        },
                        success: function(msg) {
                            console.log(msg);
                            //var events = msg.events;
                            //callback(events);
                        }
                    });
                }
            },
        ],
    });
}

// Used to calculate the data for the chart
function calculateChart(emp)
{
    $.ajax({
        url: "../../EmployeeManager/Master/Server_Scripts/ManageEmployeesManager.php",
        method: "post",
        data: {getTimeSheet: true, employee_id:emp["id"]},
        success:function(data)
        {
            var temp = JSON.parse(data);
        }
    });
}

// Used to show the datatable
function showTable() {
    console.log("show table");
    // Creating data table and defining its properties
    var table = $('#dataTable').DataTable({
        "processing": true,
        "serverside": true,
        "lengthMenu": [20, 40, 60, 80, 100],
        "destroy": true,

        // Displaying loading gif
        "language": {
            "processing": "<figure id='figLoad'>" +
            "<img src='../../EmployeeManager/Forms/LoadingGifs/loading-gif-1.gif' style='width: 50%; height: 50%;'><figcaption>Loading</figcaption></figure>"
        },

        "initComplete": function () {
            console.log("Table done loading...");
        },

        // Getting select statement
        ajax:
            {
                url: "../Master/Server_Scripts/ManageEmployeesManager.php?getDataTable=" + true,
            },

        columns: [
            {data: 'id'},
            {data: 'first_name'},
            {data: 'last_name'},
            {data: 'gender'},
            {data: 'hire_date'},
            {data: 'employee_number'},
            {data: 'admin'},
            {data: 'title'},
            {data: 'street_address'}
        ]
    });
}