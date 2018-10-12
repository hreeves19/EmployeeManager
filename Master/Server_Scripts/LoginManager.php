<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 10/11/2018
 * Time: 8:00 PM
 */

require_once("C:/xampp/htdocs/EmployeeManager/Classes/DBHelper.php");

if(isset($_POST["enumber"]) && isset($_POST["psw"]))
{
    $DB = new DBHelper();
    $DB->getUsername();
}
