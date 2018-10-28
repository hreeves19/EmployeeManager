<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/24/2018
 * Time: 6:19 PM
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

// Checking if employee is a manager
if((int) $session->getisManager())
{
    $data = $DB->getEvents((int) $session->getisManager());
}

// Not a manager
else
{
    $data = $DB->getEvents((int) $session->getManagersId());
}

// Setting default timezone
date_default_timezone_set('America/Chicago');

$data_events[] = array();
foreach($data as $key => $value)
{
    // Getting times
    $start_time = $value["start_time"];
    $end_time = $value["end_time"];
    $date = $value["date"];
    $color = "";

    // if its mandatory
    if((int) $value["mandatory"] == 1)
    {
        $color = "#DC3546";
    }

    else
    {
        $color = "#0279FF";
    }

    // Need to explode to get hours and minutes, these are now arrays
    // 0 element = hours, 1 element = minutes, 2 element = seconds
    $start_time = explode(":", $start_time);
    $end_time = explode(":", $end_time);

    // Creating date objects w/ time
    $event_date_start = new DateTime($date);
    $event_date_start->setTime($start_time[0], $start_time[1], $start_time[2]); // Hours, minutes, seconds
    $event_start_format = $event_date_start->format('Y-m-d H:i:s');

    // Creating date objects w/ time
    $event_date_end = new DateTime($date);
    $event_date_end->setTime($end_time[0], $end_time[1], $end_time[2]); // Hours, minutes, seconds
    $event_end_format = $event_date_end->format('Y-m-d H:i:s');

    $data_events[$key] = array(
        "id" => $value["event_id"],
        "title" => $value["name"],
        "description" => $value["description"],
        "end" => $event_end_format,
        "start" => $event_start_format,
        "color" => $color,
        "textColor" => "#ffffff",
        "mandatory" => $value["mandatory"]
    );
}

echo json_encode(array("events" => $data_events));
?>