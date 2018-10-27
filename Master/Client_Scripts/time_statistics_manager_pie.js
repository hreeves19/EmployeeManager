// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
var totalHours = 40;
var hoursWorked = 0;
var pieHoursLeft = 0;

$.ajax({
    type: "POST",
    url: "../../EmployeeManager/Master/Server_Scripts/PieChartStatistics.php",
    success: function(data)
    {
        var objArray = JSON.parse(data);
        console.log(objArray);

        for(var i = 0; i < objArray.length; i++)
        {
            console.log("Adding " + objArray[i].number_hours + " to " + hoursWorked);
            hoursWorked += parseFloat(objArray[i].number_hours);
        }

        pieHoursLeft = totalHours - hoursWorked;
        console.log("Total Work Hours: " + totalHours);
        console.log("Hours hoursWorked: " + hoursWorked);
        console.log("Hours left: " + pieHoursLeft);

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            // Getting select statement
            data: {
                labels: ["Hours Worked", "Hours Left"],
                datasets: [{
                    data: [hoursWorked, pieHoursLeft],
                    // #8DC641 #21357E
                    backgroundColor: ['#27A844', '#F9C306'],
                }],
            },
        });
    }
});