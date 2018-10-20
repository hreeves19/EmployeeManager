<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/17/2018
 * Time: 11:01 PM
 */
// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../../EmployeeManager/Classes/SessionManager.php');
require_once("../../../EmployeeManager/Classes/DBHelper.php");

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

// Getting monday of this week and friday
$monday = date('Y-m-d', strtotime('monday this week'));
$friday = date('Y-m-d', strtotime("friday this week"));
$now = date('Y-m-d', strtotime("now"));

// Need to move to next week
if($now > $friday)
{
    $monday = date('Y-m-d', strtotime('next monday'));
    $friday = date('Y-m-d', strtotime('next friday'));
}

// Getting data
$data = $DB->getPieChartData($monday, $friday, $session->getPrimarykey());

echo json_encode($data);
?>