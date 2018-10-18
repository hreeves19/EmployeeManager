<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/14/2018
 * Time: 10:36 PM
 */

// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../EmployeeManager/Classes/SessionManager.php');

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
/****************************************************************************/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Time Sheet</title>

    <!-- Bootstrap core CSS-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/css/sb-admin.css" rel="stylesheet">

</head>
<body id="page-top">
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="../../EmployeeManager/Forms/Home.php">Employee Management System</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <div class="input-group-append">
            </div>
        </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../../EmployeeManager/Forms/Login.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>
</nav>

<div id="wrapper">
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
        <!-- Time sheet -->
        <li class="nav-item">
            <a class="nav-link" href="../../EmployeeManager/Forms/TimeSheet.php">
                <i class="fas fa-fw fa-clipboard"></i>
                <span>Time Sheet</span>
            </a>
        </li>
    </ul>

    <div id="content-wrapper">
        <div class="container-fluid">
            <h1 style="text-align: center">Time Sheet</h1>
            <hr>
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Time Submission</div>
                <div class="card-body">
                    <form id="formTimeSheet" action="../../EmployeeManager/Master/Server_Scripts/TimeSheetManager.php" method="post" accept-charset="UTF-8" onsubmit="return validateForm(this)">
                        <!-- Enter Time From -->
                        <div class="form-group">
                            <div class="form-label-group">
                                <input id="timef" type="time" name="timef" class="form-control" placeholder="Time From" required="required" autofocus="autofocus" min="08:00" max="17:00">
                                <label for="timef">Time From</label>
                            </div>
                        </div>
                        <!-- Enter Time To -->
                        <div class="form-group">
                            <div class="form-label-group">
                                <input id="timet" type="time" name="timet" class="form-control" placeholder="Time To" required="required" min="08:00" max="17:00">
                                <label for="timet">Time To</label>
                            </div>
                        </div>
                        <!-- Enter Date -->
                        <div class="form-group">
                            <div class="form-label-group">
                                <input id="date" type="text" name="date" class="form-control" placeholder="Date" required="required">
                                <label for="date">Date</label>
                            </div>
                        </div>
                        <!-- Hidden Hours Worked -->
                        <div class="form-group">
                            <div class="form-label-group">
                                <input id="hours" type="text" name="hours" class="form-control" placeholder="Hours" style="display: none;">
                                <label for="hours"></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" onclick="calculateHours()">Submit Time</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2018</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="../../EmployeeManager/Forms/Login.php">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/js/sb-admin.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../../EmployeeManager/Master/Client_Scripts/timesheet_manager.js"></script>

<script>
    $( function() {
        $( "#date" ).datepicker({dateFormat: "yy-mm-dd"});
    } );
</script>
</body>
</html>
