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
else if(isset($_POST["getTimeSheet"]) && isset($_POST["employee_id"]))
{
    // The Current pay period is the date as a string, the date is the day that the pay period ends
    $currentPayPeriod = $DB->getLatestPayPeiod();
    $currentPayPeriod = $currentPayPeriod["MAX(`date_to`)"];

    // Getting the employees id through the post array
    $employee_id = $_POST["employee_id"];

    // Getting their timesheet
    $timesheet = $DB->selectAllTimeSheet($employee_id, $DB->getLatestPayPeiod());

    echo json_encode($timesheet);
}

else
{
    echo "Something went wrong.";
}