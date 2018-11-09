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

if(isset($_GET["getDataTable"]))
{
    $data = $DB->getEmployees($session->getIsManager());
    echo json_encode(array("data" => $data));
}

else
{
    echo "Something went wrong.";
}