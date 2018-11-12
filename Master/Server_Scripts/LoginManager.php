<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 10/11/2018
 * Time: 8:00 PM
 */

require_once("../../../EmployeeManager/Classes/DBHelper.php");
require_once('../../../EmployeeManager/Classes/SessionManager.php');

session_start();

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
        $_SESSION['primarykey'] = $data['id'];
        $_SESSION['employeeNumber'] = $data['employee_number'];
        $_SESSION['firstName'] = $data["first_name"];
        $_SESSION['lastName'] = $data["last_name"];
        $_SESSION['isManager'] = $manager;
        $_SESSION['isAdmin'] = $data["admin"];
        $_SESSION['address'] = $data["street_address"];
        $_SESSION['city'] = $data["city"];
        $_SESSION['zipcode'] = $data["zipcode"];
        $_SESSION['state'] = $data["state"];
        $_SESSION['title'] = $data["title"];
        $_SESSION['salary_per_hour'] = $data["salary_per_hour"];
        $_SESSION['hireDate'] = $data["hire_date"];

        // Getting employee's manager id, if its 0 it means that this person is a manager
        $manager_id = $DB->getEmployeesManager((int) $data["id"]);
        $arrayName = $DB->getEmployeeManagerName((int) $manager_id["dept_manager_id"]);

        // Setting more sessions
        $_SESSION['manager_id'] = $manager_id;
        $_SESSION['manager_name'] = $arrayName["first_name"] . " " . $arrayName["last_name"];

        $session = new SessionManager();
        $_SESSION['sessionobj'] = $session;

        // After signing in and creating session manager obj, we relocate the user to the home page
        header("Location: ../../Forms/Home.php");
    }

    else
    {
        //header("location: ../../Forms/Login.php");
        echo "Failed to login.";
    }
}
