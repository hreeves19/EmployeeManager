<?php
/**
 * Created by PhpStorm.
 * User: final
 * Date: 10/31/2018
 * Time: 4:36 PM
 */

/********************************************************************************/
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
/***********************************************************************************/
$DB = new DBHelper();

if(isset($_POST["img"]))
{

    $filePath = $DB->getImage($session->getEmployeeNumber());
    //echo $filePath["image"];
    echo "<img src='" . $filePath['image'] ."' class='img-thumbnail'>";
}

// check for form request method
else if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // check for uploaded file
    if (isset($_FILES['upload'])) {
        // file name, type, size, temporary name
        $file_name = $_FILES['upload']['name'];
        $file_type = $_FILES['upload']['type'];
        $file_tmp_name = $_FILES['upload']['tmp_name'];
        $file_size = $_FILES['upload']['size'];

        // target directory
        $target_dir = "../../EmployeeManager/Master/Profile_Images/";

        // uploading file
        if (move_uploaded_file($file_tmp_name, $target_dir . $file_name))
        {
            $DB->imageUpload($target_dir, $file_name, $session->getEmployeeNumber());
        }
    }
}