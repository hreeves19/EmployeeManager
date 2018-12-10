var pastData = 0;
var count = 0;
var cpuUsage = [];

$(document).ready(function(){
    // Start intervals
    showDiskUsage();

    // Setting interval
    setInterval(function(){
        if((count % 2) === 0)
        {
            getData();

            // Checking array size, max is 5
            if(cpuUsage.length === 5)
            {
                cpuUsage.shift();
                cpuUsage.push(pastData);
            }

            else
            {
                cpuUsage.push(pastData);
            }
        }

        // Increment counter
        count++;
    }, 2000);

    // Setting interval for showing the chart
    setInterval(function() {
        if(cpuUsage.length === 5)
        {
            showChart();
        }
    }, 4000);
});

function getData()
{
    $.ajax({
        type: "POST",
        url: "../../EmployeeManager/Master/Server_Scripts/NetworkManager.php",
        data:{lineChart: true},
        success: function(data)
        {
            pastData = JSON.parse(data);
        }
    });
}

function showChart()
{
    // Showing chart and hiding gif
    document.getElementById("loadingImage").style.display = "none";
    document.getElementById("myLineChart").style.display = "block";
    $.ajax({
        type: "POST",
        url: "../../EmployeeManager/Master/Server_Scripts/NetworkManager.php",
        data:{lineChart: true},
        success: function(data)
        {
            console.log(cpuUsage);

            // Line Chart Example
            var ctx = document.getElementById("myLineChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                scaleOverride : true,
                scaleSteps : 10,
                scaleStepWidth : 100,
                scaleStartValue : 0,
                options: {
                    animation: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 100
                            }
                        }]
                    }
                },
                data: {
                    labels: ["8 Seconds ago", "6 seconds ago", "4 seconds ago", "2 second ago", "Current"],
                    datasets: [{
                        label: "CPU Usage",
                        data: [cpuUsage[0], cpuUsage[1], cpuUsage[2], cpuUsage[3], cpuUsage[4]],
                        // #8DC641 #21357E
                        borderColor: ['#4286f4']
                    }],
                },
            });
        }
    });
}

function showDiskUsage()
{
    $.ajax({
        type: "POST",
        url: "../../EmployeeManager/Master/Server_Scripts/NetworkManager.php",
        data:{storageStatistics: true},
        success: function(data)
        {
            data = JSON.parse(data);
            console.log(data);
            document.getElementById("storageTitle").innerHTML = "<i class=\"fas fa-chart-pie\"></i> Server Storage Statistics in " + data.diskFormat;
            document.getElementById("totalStorage").innerHTML = "Total Space on Server: <b>" + data.diskTotal + " " + data.diskFormat + "</b>";
            // Pie Chart Example
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                // Getting select statement
                data: {
                    labels: ["Free Space", "Used Space"],
                    datasets: [{
                        data: [data.diskFree, data.diskRemaining],
                        // #8DC641 #21357E
                        backgroundColor: ['#27A844', '#F9C306'],
                    }],
                },
            });
        }
    });
}