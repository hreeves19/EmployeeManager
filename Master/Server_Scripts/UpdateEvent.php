<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/28/2018
 * Time: 1:44 AM
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

// Setting default timezone
date_default_timezone_set('America/Chicago');

var_dump($_POST);
// Checking to see if we need to delete
if(isset($_POST["delete"]) && isset($_POST["id"]))
{
    $DB->deleteEvent((int) $_POST["id"]);
    $_SESSION["message"] = "Event successfully deleted!";
}

else
{
    $DB->updateEvent($_POST["eventName"], $_POST["eventStart"],  $_POST["eventEnd"], $_POST["eventDescription"], (int) $_POST["mandatory"], (int) $session->getisManager(), $_POST["selectedDate"], (int) $_POST["eventid"]);
}
?>