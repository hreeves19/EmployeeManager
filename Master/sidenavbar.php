<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/20/2018
 * Time: 6:22 PM
 */

?>

<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <!-- Home page -->
    <li class="nav-item">
        <a class="nav-link" href="../../EmployeeManager/Forms/Home.php">
            <i class="fas fa-fw fa-compass"></i>
            <span>Home</span>
        </a>
    </li>
    <!-- Register new user admins only -->
    <?php
    // Checking if admin
    if((int) $session->getIsAdmin() == 1)
    {
        echo "<li class=\"nav-item\">
            <a class=\"nav-link\" href=\"../../EmployeeManager/Forms/SignUp.php\">
            <i class='fas fa-fw fa-user'></i>
                <span>Register New User</span>
            </a>
        </li>";
    }
    ?>
    <!-- Submit Time sheet -->
    <li class="nav-item">
        <a class="nav-link" href="../../EmployeeManager/Forms/TimeSheet.php">
            <i class="fas fa-fw fa-clock"></i>
            <span>Submit Time Sheet</span>
        </a>
    </li>
    <!-- Time sheet -->
    <li class="nav-item">
        <a class="nav-link" href="../../EmployeeManager/Forms/DataTableTimeSheet.php">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>View Time Sheet</span>
        </a>
    </li>
    <!-- Manage Employees -->
    <?php
    // Checking to see if they have a manager id
        if((int) $session->getisManager() >= 1)
        {
            echo "<li class=\"nav-item\">
        <a class=\"nav-link\" href=\"../../EmployeeManager/Forms/ManageEmployees.php\">
            <i class=\"fas fa-fw fa-address-book\"></i>
            <span>Manage Employees</span>
        </a>
    </li>";
        }
    ?>
</ul>
