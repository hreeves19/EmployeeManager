<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 10/23/2018
 * Time: 4:52 PM
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

var_dump($_POST);
$mandatory = 1;


if($_POST["mandatory"] === "0")
{
    $mandatory = 0;
}

// This is for selecting several days
if(isset($_POST["selectedDateEnd"]))
{
    // Inserting the event
    $DB->addEvent($_POST["eventName"], $_POST["eventStart"],  $_POST["eventEnd"], $_POST["eventDescription"], $mandatory, (int) $session->getisManager(), $_POST["selectedDate"], $_POST["selectedDateEnd"]);

}

else
{
    // Inserting the event
    $DB->addEvent($_POST["eventName"], $_POST["eventStart"],  $_POST["eventEnd"], $_POST["eventDescription"], $mandatory, (int) $session->getisManager(), $_POST["selectedDate"], $_POST["selectedDate"]);

}
?>