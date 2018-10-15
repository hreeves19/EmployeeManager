<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/14/2018
 * Time: 4:18 PM
 */
session_start();
$firstname = $_SESSION['first_name'];
?>
<!DOCTYPE html>
<html>
<title>Home</title>
<body>

<?php echo "<h1>Welcome $firstname!</h1>" ?>

</body>
</html
