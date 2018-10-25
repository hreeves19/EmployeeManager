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

if(isset($_SESSION["message"]))
{
    echo $_SESSION["message"];
    unset($_SESSION["message"]);
}
/****************************************************************************/

$data = $DB->getEvents((int) $session->getisManager());

var_dump($data);

/*$data_events[] = array(
    "id" => $r->ID,
    "title" => $r->title,
    "description" => $r->description,
    "end" => $r->end,
    "start" => $r->start
);*/
$data_events[] = array();
foreach($data as $key => $value)
{
    $data_events[$key] = array(
        "id" => $value["event_id"],
        "title" => $value["name"]
    );
}

var_dump($data_events);
?>