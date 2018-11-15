<?php
/**
 * Created by PhpStorm.
 * User: final
 * Date: 11/12/2018
 * Time: 12:42 PM
 */

// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../../EmployeeManager/Classes/SessionManager.php');
require('../../../EmployeeManager/Classes/DBHelper.php');

$DB = new DBHelper();

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
/****************************************************************************/

$latestPayPeriod = $DB->getLatestPayPeiod();
$currentPayPeriod = $latestPayPeriod["MAX(`date_to`)"];

$data = $DB->selectAllTimeSheet((int) $session->getPrimarykey(), $DB->getLatestPayPeiod());

// Setting default timezone
date_default_timezone_set('America/Chicago');

$data_events[] = array();
foreach($data as $key => $value)
{
    // Getting times
    $start_time = $value["time_from"];
    $end_time = $value["time_to"];
    $date = $value["date"];
    $dateEnd = $value["date"];
    $color = "#0279FF";


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
        "description" => $value["number_hours"],
        "end" => $event_end_format,
        "start" => $event_start_format,
        "color" => $color,
        "textColor" => "#ffffff",
    );
}

echo json_encode(array("events" => $data_events));
?>