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
            showCalendar(employee[0]["id"]);
        }
    });
}

function showNewCalendar()
{
    // Getting selected value from the employees ddl
    var employee = document.getElementById("ddlEmployees").value;
    employee = parseInt(employee);

    // Getting today's current date
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    // Destroy calendar, then redraw it
    $('#calendar').fullCalendar( 'destroy' );
    showCalendar(employee);
}

function showCalendar(employee)
{
    // Getting today's current date
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

    // Getting range for work week
    var text = document.getElementById("payPeriod").value;

    /*text = text.match(/\d\d\d\d-\d\d-\d\d/g);*/
    console.log(text);

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'listDay,agendaWeek,month'
        },

        visibleRange: {
            start: '2017-03-22',
            end: '2017-03-25'
        },

        // customize the button names,
        // otherwise they'd all just say "list"
        views: {
            listDay: { buttonText: 'list day' },
            listWeek: { buttonText: 'list week' }
        },

        defaultView: 'agendaWeek',
        defaultDate: date,
        navLinks: true, // can click day/week names to navigate views
        eventSources: [
            {
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '../../EmployeeManager/Master/Server_Scripts/ManageEmployeesManager.php',
                        method: "post",
                        data: {getTimeSheet: true, employee_id:employee},
                        dataType: 'json',
                        success: function(msg) {
                            console.log(msg);
                            var events = msg.events;
                            callback(events);
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
        data: {getTimeSheet: true, employee_id:emp[0]["id"]},
        success:function(data)
        {
            console.log(data);
        }
    });
}

// Used to show the datatable
function showTable() {
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

function approveSheet()
{
    // Getting selected value from the employees ddl
    var employee = document.getElementById("ddlEmployees").value;
    employee = parseInt(employee);

    // Making an ajax call to approve the time sheet
    $.ajax({
        url: "../../EmployeeManager/Master/Server_Scripts/ManageEmployeesManager.php",
        method: "post",
        data: {status: 1, employee_id:employee},
        success:function(data)
        {
            console.log(data);
            // Destroy calendar, then redraw it
            $('#calendar').fullCalendar( 'destroy' );
            showCalendar(employee);
        }
    });
}

function disapproveSheet()
{
    // Getting selected value from the employees ddl
    var employee = document.getElementById("ddlEmployees").value;
    employee = parseInt(employee);

    // Making an ajax call to approve the time sheet
    $.ajax({
        url: "../../EmployeeManager/Master/Server_Scripts/ManageEmployeesManager.php",
        method: "post",
        data: {status: 0, employee_id:employee},
        success:function(data)
        {
            console.log(data);
            // Destroy calendar, then redraw it
            $('#calendar').fullCalendar( 'destroy' );
            showCalendar(employee);
        }
    });
}

function resetSheet()
{
    // Getting selected value from the employees ddl
    var employee = document.getElementById("ddlEmployees").value;
    employee = parseInt(employee);

    // Making an ajax call to approve the time sheet
    $.ajax({
        url: "../../EmployeeManager/Master/Server_Scripts/ManageEmployeesManager.php",
        method: "post",
        data: {status: 0, employee_id:employee},
        success:function(data)
        {
            console.log(data);
            // Destroy calendar, then redraw it
            $('#calendar').fullCalendar( 'destroy' );
            showCalendar(employee);
        }
    });
}