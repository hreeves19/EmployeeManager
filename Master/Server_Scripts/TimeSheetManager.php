<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/17/2018
 * Time: 11:10 AM
 */

require_once ("../../../EmployeeManager/Classes/DBHelper.php");

// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../../EmployeeManager/Classes/SessionManager.php');

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

$DB = new DBHelper();

if(isset($_POST["date"]) && isset($_POST["timef"]) && isset($_POST["timet"]) && $_POST["hours"])
{
    var_dump($_POST);

    // Need the latest pay period
    $currentPeriod = $DB->getLatestPayPeiod();
    $currentPeriod = $currentPeriod["MAX(`date_to`)"];

    // Getting other variables
    $dateSpecified = $_POST["date"];
    $timef = $_POST["timef"] . ":00";
    $timet = $_POST["timet"] . ":00";
    $hours = $_POST["hours"];

    $DB->submitHours($hours, $dateSpecified, $session->getPrimarykey(), $currentPeriod, $timef, $timet);

   /* $_SESSION["message"] = "<script>alert(\"Your time sheet has been aproved!\");</script>";*/

    header("Location: ../../../EmployeeManager/Forms/TimeSheet.php");
}

// Populating datatable from time_sheet
if(isset($_GET["datatable"]))
{
    $currentPeriod = $DB->getLatestPayPeiod();
    $data = $DB->selectAllTimeSheet($session->getPrimarykey(), $currentPeriod);
    echo json_encode(array('data' => $data));
}
?>