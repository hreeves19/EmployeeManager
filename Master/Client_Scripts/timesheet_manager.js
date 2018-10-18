var worked;

function validateForm(form)
{
    // User entered wrong time
    if(worked < 0)
    {
        alert("Your time came out negative, fix the times!");
        return false;
    }

    else
    {
        return confirm("Are you sure you want to submit your time?");
    }
}

function convertMilllisecondsToMinutes(milseconds)
{
    return milseconds / 60000;
}

function calculateHours()
{
    // Getting time variables
    var from = document.getElementById("timef").value;
    var to = document.getElementById("timet").value;
    var date = document.getElementById("date").value;

    // Converting times
    from = from.split(":");
    to = to.split(":");

    // Converting date
    date = date.split("-");

    from = new Date(parseInt(date[0]), parseInt(date[1]) - 1 , parseInt(date[2]), parseInt(from[0]), parseInt(from[1]), 0, 0).getTime();
    to = new Date(parseInt(date[0]), parseInt(date[1]) - 1 , parseInt(date[2]), parseInt(to[0]), parseInt(to[1]), 0, 0).getTime();

    // Getting minutes
    from = convertMilllisecondsToMinutes(from);
    to = convertMilllisecondsToMinutes(to);
    worked = (to - from) / 60;

    // Adding it to an input so it goes to server
    document.getElementById("hours").value = worked;
}

function callTimeSheet()
{
    // Making a request to the server to get the pay period
    var xmlhttp = new XMLHttpRequest();

    // Calling the server
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {

        }
    };

    // Telling it where to go, what method to use, and what parameters i want to pass
    xmlhttp.open("POST", "../../EmployeeManager/Master/Server_Scripts/TimeSheetManager.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("dataTable=" + true);
}