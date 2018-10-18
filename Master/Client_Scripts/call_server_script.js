// Calling the server to get the latest pay period
function getLatest()
{
    // Set the date we're counting down to
    var latest = "";

    // Making a request to the server to get the pay period
    var xmlhttp = new XMLHttpRequest();

    // Calling the server
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            // Parsing the json encoded response from the server
            latest = JSON.parse(this.responseText);
            latest = latest["MAX(`date_to`)"];
            latest = latest.split("-");
            console.log(latest);
            startCountDown(latest);
        }
    };

    // Telling it where to go, what method to use, and what parameters i want to pass
    xmlhttp.open("POST", "../../EmployeeManager/Master/Server_Scripts/HomeManager.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("getLatestPayPeriod=" + true);
}

// Starting the count down function
function startCountDown(latest)
{
    var countDownDate = new Date(parseInt(latest[0]), parseInt(latest[1]) - 1 , parseInt(latest[2]), 17, 30, 0, 0).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').innerText = days;
        document.getElementById('hours').innerText = hours;
        document.getElementById('minutes').innerText = minutes;
        document.getElementById('seconds').innerText = seconds;
        document.getElementById("divClock").style.display = "block";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
        }
    }, 1000);
}