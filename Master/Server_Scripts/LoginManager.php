<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 10/11/2018
 * Time: 8:00 PM
 */

require_once("C:/xampp/htdocs/EmployeeManager/Classes/DBHelper.php");
session_start(); // Starting session

if(isset($_POST["enumber"]) && isset($_POST["psw"]))
{
    $enumber = $_POST["enumber"];
    $password = $_POST["psw"];

    $DB = new DBHelper();
    $firstName = $DB->authenticateUser($enumber, $password);
    $manager = $DB->checkManager($enumber, $password);

    // Checking to see if we found the user
    if($firstName != "")
    {
        echo "passed";
        // Creating a session
        $_SESSION['first_name'] = $firstName;
        $_SESSION['manager_id'] = $manager;
        header("Location: ../../Forms/Home.php");
    }

    else
    {
        header("location: ../../Forms/Login.php");
        echo "Failed to login.";
    }
}
