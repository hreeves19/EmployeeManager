<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/14/2018
 * Time: 4:18 PM
 */
session_start();
$firstname = $_SESSION['first_name'];
$manager = $_SESSION['manager_id'];
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home</title>
<head>
    <link rel="stylesheet" type="text/css" href="../../EmployeeManager/Master/CSS/master.css">
</head>
<body>
<div class="flex-container">
    <div>
        <?php
        if($manager > 0)
        {
            echo "<h1>Welcome Manager $firstname!</h1>";
        }

        else
        {
            echo "<h1>Welcome $firstname!</h1>";
        }
        ?>
    </div>
</div>
</body>
</html
