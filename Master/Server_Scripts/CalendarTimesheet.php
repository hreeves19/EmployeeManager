<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 11/10/2018
 * Time: 9:41 PM
 */
// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../../EmployeeManager/Classes/SessionManager.php');
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

// Checking to see if variables are set, this is to update the calendar on the ManageEmployees.php
if(isset($_POST["employee"]))
{

}

else
{
    echo "Something went wrong.";
}
?>