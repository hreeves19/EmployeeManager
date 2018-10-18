// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
var totalWorkHours = 40;
var worked = 0;
var hoursLeft = 0;

$.ajax({
    type: "POST",
    url: "../../EmployeeManager/Master/Server_Scripts/PieChartStatistics.php",
    success: function(data)
    {
        var result = JSON.parse(data);
        console.log(result);

        for(var i = 0; i < result.length; i++)
        {
            console.log(result[i].time_id);
            worked += parseFloat(result[i].number_hours);
        }

        hoursLeft = totalWorkHours - worked;

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            // Getting select statement
            data: {
                labels: ["Hours Worked", "Hours Left"],
                datasets: [{
                    data: [worked, hoursLeft],
                    backgroundColor: ['#8DC641', '#21357E'],
                }],
            },
        });
    }
});