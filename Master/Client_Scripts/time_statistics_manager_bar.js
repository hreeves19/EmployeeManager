// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var totalWorkHours = 40;
var worked = 0;
var hoursLeft = 0;
var days = [0, 0, 0, 0, 0, 0, 0];

$.ajax({
    type: "POST",
    url: "../../EmployeeManager/Master/Server_Scripts/PieChartStatistics.php",
    success: function(data)
    {
        var result = JSON.parse(data);
        console.log("Length" + result.length);

        // Looping through array of objects
        for(var i = 0; i < result.length; i++)
        {
            // Counting the number of hours
            worked += parseFloat(result[i].number_hours);

            // Date, Sunday = 0, Monday = 1
            var date = new Date(result[i].date);
            var position = date.getDay();
            days[position] += parseFloat(result[i].number_hours);
        }

        hoursLeft = totalWorkHours - worked;

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Monday", "Tuesday", "wednesday", "Thursday", "Friday"],
                datasets: [{
                    label: "Hours Worked",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [days[0], days[1], days[2], days[3], days[4]],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 15,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(0, 0, 0)'
                    }
                }
            }
        });
    }
});