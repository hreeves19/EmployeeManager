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
<title>Home</title>
<body>

<?php
echo "<br>Manager: $manager";
if($manager > 0)
{
    echo "<h1>Welcome Manager $firstname!</h1>";
}

else
{
    echo "<h1>Welcome $firstname!</h1>";
}
?>

</body>
</html
