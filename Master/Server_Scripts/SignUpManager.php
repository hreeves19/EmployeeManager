<?php
/**
 * Created by PhpStorm.
 * User: final
 * Date: 10/14/2018
 * Time: 3:52 PM
 */

require_once("C:/xampp/htdocs/EmployeeManager/Classes/DBHelper.php");

if(isset($_POST["FirstName"]) && isset($_POST["LastName"]) && isset($_POST["gender"]) && isset($_POST["Password"]) && isset($_POST["Address"]) && isset($_POST["ZipCode"]) && isset($_POST["City"]) && isset($_POST["State"]) && isset($_POST["Country"]) && isset($_POST["date"]))
{
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $gender = $_POST["gender"];
    $password = $_POST["Password"];
    $address = $_POST["Address"];
    $zip = $_POST["ZipCode"];
    $city = $_POST["City"];
    $state = $_POST["State"];
    $country = $_POST["Country"];
    $date = $_POST["date"];

    $DB = new DBHelper();

    $DB->signUp($address, $city, $zip, $state, $country, $firstName, $lastName, $gender, $password, $date);


}

else if(isset($_POST["getDDLTitle"]))
{
    var_dump($_POST);
}