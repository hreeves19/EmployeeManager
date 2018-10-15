<?php
/**
 * Created by PhpStorm.
 * User: final
 * Date: 9/13/2018
 * Time: 8:10 PM
 */
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <link rel="stylesheet" type="text/css" href="../../EmployeeManager/Master/CSS/master.css">
    <style>
        body
        {
            font-family: Arial, Helvetica, sans-serif;
        }

        form
        {
            display: flex;
            justify-content: center;
        }

        form > div
        {
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<title>Login</title>
<body>
<div class="flex-container">
    <div id="divTitle">
        <h1>Login</h1>
    </div>
    <form id="formLogin" action="../../EmployeeManager/Master/Server_Scripts/LoginManager.php" method="post" accept-charset="UTF-8">
        <div>
            <div id="divEmployeeNumber">
                <label for="enumber"><b>Employee Number: </b></label><br>
                <input type="text" placeholder="Enter Employee Number" name="enumber" required>
            </div>
            <div id="divPassword" style="padding-bottom: 10px;">
                <label for="psw"><b>Password: </b></label><br>
                <input type="password" placeholder="Enter Password" name="psw" required>
            </div>
            <div id="divSubmitBtn">
                <button type="submit">Login</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>

