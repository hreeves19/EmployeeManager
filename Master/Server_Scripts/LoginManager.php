<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 10/11/2018
 * Time: 8:00 PM
 */

require_once("../../../EmployeeManager/Classes/DBHelper.php");
require_once('../../../EmployeeManager/Classes/SessionManager.php');

if(isset($_POST["enumber"]) && isset($_POST["psw"]))
{
    $enumber = $_POST["enumber"];
    $password = $_POST["psw"];

    $DB = new DBHelper();
    $data = $DB->authenticateUser($enumber, $password);
    $manager = $DB->checkManager($enumber, $password);

    // Checking to see if we found the user
    if($data != "")
    {
        // Checking to see if user is a manager
        if($manager < 1)
        {
            $manager = false;
        }

        // Creating a session
        // Example of what data looks like
        // array(5) { ["id"]=> string(1) "1" ["first_name"]=> string(4)
        // "John" ["last_name"]=> string(3) "Doe" ["employee_number"]=> string(9) "123456789"
        // ["admin"]=> string(1) "0" }
        $session = SessionManager::login($data["id"], $data["employee_number"], $data["first_name"],
            $data["last_name"], $manager, $data["admin"], true);
        $_SESSION['userSession'] = $session;

        header("Location: ../../Forms/Home.php");
    }

    else
    {
        header("location: ../../Forms/Login.php");
        echo "Failed to login.";
    }
}
