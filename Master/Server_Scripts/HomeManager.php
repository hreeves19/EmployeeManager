<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/16/2018
 * Time: 11:49 PM
 */
//SELECT MAX(`date_to`) FROM `pay_period
require_once("../../../EmployeeManager/Classes/DBHelper.php");

$DB = new DBHelper();

if(isset($_POST["getLatestPayPeriod"]))
{
    $latest = $DB->GET_LATEST_PAY_PERIOD();

    echo json_encode($latest);
}

else
{
    echo "Cannot get the latest pay period.";
}
?>