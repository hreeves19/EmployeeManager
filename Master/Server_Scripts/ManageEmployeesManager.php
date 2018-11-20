<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 11/7/2018
 * Time: 12:49 PM
 */

// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../Classes/SessionManager.php');
require('../../Classes/DBHelper.php');

session_start();

// Checking to see if session exists, if it doesn't redirect user to log in
if(session_id() != '' && isset($_SESSION['sessionobj']))
{
    $session = $_SESSION['sessionobj'];
    $session->setLoggedIn(true);
}

else
{
    header("Location: ../../EmployeeManager/Forms/Login.php");
}

if(isset($_SESSION["message"]))
{
    echo $_SESSION["message"];
    unset($_SESSION["message"]);
}
/****************************************************************************/
$DB = new DBHelper();

// This is used to get the datatable on the employee management page
if(isset($_GET["getDataTable"]))
{
    // We are getting all the employees and their relevant information
    $data = $DB->getEmployees($session->getIsManager());
    echo json_encode(array("data" => $data));
}

// This is used to get all the employee under a manager
else if(isset($_POST["getEmployees"]))
{
    $data = $DB->getEmployees($session->getIsManager());
    echo json_encode($data);
}

// We are trying to get the timesheet of the employee being passed in
else if(isset($_POST["getTimeSheet"]) && isset($_POST["employee_id"]) && isset($_POST["payperiod"]))
{
    // The Current pay period is the date as a string, the date is the day that the pay period ends
    $currentPayPeriod = $DB->getLatestPayPeiod();
    $currentPayPeriod = $currentPayPeriod["MAX(`date_to`)"];

    // Getting the employees id through the post array
    $employee_id = $_POST["employee_id"];

    // Getting pay period
    $pay_period = $_POST["payperiod"];

    // Getting their timesheet
    $timesheet = $DB->selectAllTimeSheet((int) $employee_id, $pay_period, true);

    // Setting default timezone
    date_default_timezone_set('America/Chicago');

    $data_events[] = array();

    foreach($timesheet as $key => $value)
    {
        // Getting times
        $start_time = $value["time_from"];
        $end_time = $value["time_to"];
        $date = $value["date"];
        $dateEnd = $value["date"];
        $color = "#0279FF";

        // Checking to see if timesheet hasn't been approved
        if((int) $value["approved"] == 0)
        {
            // Change the color to red
            $color = "#DC3546";
        }

        // Need to explode to get hours and minutes, these are now arrays
        // 0 element = hours, 1 element = minutes, 2 element = seconds
        $start_time = explode(":", $start_time);
        $end_time = explode(":", $end_time);

        // Creating date objects w/ time, start
        $event_date_start = new DateTime($date);
        $event_date_start->setTime($start_time[0], $start_time[1], $start_time[2]); // Hours, minutes, seconds
        $event_start_format = $event_date_start->format('Y-m-d H:i:s');

        // Creating date objects w/ time
        $event_date_end = new DateTime($dateEnd);
        $event_date_end->setTime($end_time[0], $end_time[1], $end_time[2]); // Hours, minutes, seconds
        $event_end_format = $event_date_end->format('Y-m-d H:i:s');

        $data_events[$key] = array(
            "id" => $value["time_id"],
            "title" => "Hours Worked",
            "description" => "You have worked " . $value["number_hours"],
            "end" => $event_end_format,
            "start" => $event_start_format,
            "color" => $color,
            "textColor" => "#ffffff",
        );
    }

    echo json_encode(array("events" => $data_events));
}

// Approving the employees timesheet for the current pay period
else if(isset($_POST["status"]) && isset($_POST["employee_id"]))
{
    // Will return true on success, false if negative
    $status = $DB->updateTimesheetApproved((int) $_POST["employee_id"], (int) $_POST["status"]);
}

else
{
    var_dump($_POST);
    echo "Something went wrong.";
}