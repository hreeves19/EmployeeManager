<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 11/22/2018
 * Time: 5:06 PM
 */

// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../../EmployeeManager/Classes/SessionManager.php');
require('../../../EmployeeManager/Classes/DBHelper.php');
require('../../../EmployeeManager/Classes/Server_Manager.php');

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
$server = new Server_Manager();

// For the datatable
if(isset($_GET["datatable"]))
{
    $indicesServer = array('PHP_SELF',
        'argv',
        'argc',
        'GATEWAY_INTERFACE',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_SOFTWARE',
        'SERVER_PROTOCOL',
        'REQUEST_METHOD',
        'REQUEST_TIME',
        'REQUEST_TIME_FLOAT',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'HTTP_ACCEPT',
        'HTTP_ACCEPT_CHARSET',
        'HTTP_ACCEPT_ENCODING',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CONNECTION',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTPS',
        'REMOTE_ADDR',
        'REMOTE_HOST',
        'REMOTE_PORT',
        'REMOTE_USER',
        'REDIRECT_REMOTE_USER',
        'SCRIPT_FILENAME',
        'SERVER_ADMIN',
        'SERVER_PORT',
        'SERVER_SIGNATURE',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI',
        'PHP_AUTH_DIGEST',
        'PHP_AUTH_USER',
        'PHP_AUTH_PW',
        'AUTH_TYPE',
        'PATH_INFO',
        'ORIG_PATH_INFO') ;

    foreach ($indicesServer as $arg) {
        if (isset($_SERVER[$arg])) {
            $indicesServer[$arg] = $_SERVER[$arg];
        }
    }
    //echo '</table>' ;
    echo json_encode($indicesServer);
}

else if(isset($_POST["lineChart"]))
{
    $server->setCpuLoad();
    echo json_encode($server->getCpuLoad());
}

else if(isset($_POST["storageStatistics"]))
{
    $data = array();

    // Getting storage statistics
    $data["cpuUsage"] = $server->getDiskUsage();
    $data["diskTotal"] = $server->getDisktotal();
    $data["diskFree"] = $server->getDiskfree();
    $data["diskRemaining"] = $server->getDiskRemaining();
    $data["diskFormat"] = $server->getDiskFormat();

    echo json_encode($data);
}

else
{
    echo "Something is wrong with the parameters.";
}