<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/14/2018
 * Time: 4:18 PM
 */
require('../../EmployeeManager/Classes/SessionManager.php');

// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
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

    <title>Home</title>

    <!-- Bootstrap core JavaScript-->
    <script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery/jquery.min.js"></script>
    <script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/js/sb-admin.min.js"></script>

    <!-- Bootstrap core CSS-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/css/sb-admin.css" rel="stylesheet">

    <script src="../../EmployeeManager/Master/Client_Scripts/call_server_script.js"></script>
    <link href="../../EmployeeManager/Master/CSS/master.css" rel="stylesheet">

    <!-- Page level plugin JavaScript-->
    <script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/datatables/jquery.dataTables.js"></script>
    <script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/datatables/dataTables.bootstrap4.js"></script>

    <script>
        $(document).ready(function() {
            showTable();
        });

        function showTable()
        {
            console.log("show table");
            // Creating data table and defining its properties
            var table = $('#dataTable').DataTable ({
                "processing": true,
                "serverside": true,
                "lengthMenu": [20, 40, 60, 80, 100],
                "destroy": true,

                // Displaying loading gif
                "language": {

                },

                "initComplete": function()
                {

                },

                // Getting select statement
                ajax:
                    {
                        url: "../../EmployeeManager/Master/Server_Scripts/TimeSheetManager.php?datatable=" + true
                    },

                columns: [
                    {data: 'time_id'},
                    {data: 'number_hours'},
                    {data: 'time_from'},
                    {data: 'time_to'},
                    {data: 'date'},
                    {data: 'employee_id'},
                    {data: 'pay_period_id'}
                ]
            });
        }
    </script>

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
    <?php include("../Master/sidenavbar.php") ?>

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Page Content -->
            <h1 style="text-align: center;">Your Current Time Sheet</h1>
            <hr>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Time Sheet Table</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hours Worked</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                                <th>Employee Number</th>
                                <th>Pay Period ID</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Hours Worked</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                                <th>Employee Number</th>
                                <th>Pay Period ID</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Your Time Log</div>
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
</body>
</html>

