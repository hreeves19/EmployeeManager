<?php
/**
 * Created by PhpStorm.
 * User: final
 * Date: 10/23/2018
 * Time: 2:11 PM
 */

/********************************************************************************/
require('../../EmployeeManager/Classes/SessionManager.php');
require('../../EmployeeManager/Classes/DBHelper.php');

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profile Page</title>

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
    <?php include("../Master/sidenavbar.php") ?>

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Put Page contents here -->
            <div class="container">
                <div class="card card-login mx-auto mt-5">
                    <div class="card-header">Profile</div>
                    <div   class="card-body">

                        <img src="" id="path">
                        <div id="response"></div>
                        <br>

                        <form action="../../EmployeeManager/Master/Server_Scripts/ProfilePageManager.php" method="post" enctype="multipart/form-data">
                            <p>
                                File : <input type="file" name="upload">
                            </p>
                            <input type="submit" value="upload file">
                        </form>

                        <br>

                        <form id="formLogin" action="../../EmployeeManager/Master/Server_Scripts/SignUpManager.php" method="post" accept-charset="UTF-8">

                            <!-- First and Last Name Display -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input id="FirstName" type="text" name="FirstName" class="form-control" placeholder="First Name" required="required" autofocus="autofocus" value="<?php echo $session->getFirstName(); ?>" readonly>
                                            <label for="FirstName">First Name</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <input id="LastName" type="text" name="LastName" class="form-control" placeholder="Last Name" required="required" value="<?php echo $session->getLastName(); ?>" readonly>
                                            <label for="LastName">Last Name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Title Display -->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input id="title" type="text" name="title" class="form-control" placeholder="title" required="required" value="<?php echo $session->getTitle(); ?>" readonly>
                                    <label for="title">Title</label>
                                </div>
                            </div>

                            <!-- Address display -->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input id="Address" type="text" name="Address" class="form-control" placeholder="Address" required="required" value="<?php echo $session->getAddress(); ?>" readonly>
                                    <label for="Address">Address</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright Group 8</span>
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

<!-- For date picker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function(){
        $.ajax({
           url: "../../EmployeeManager/Master/Server_Scripts/ProfilePageManager.php",
           method: "post",
           data: {img: true},
            success: function(data){
               console.log(data);
                //$("#path").attr("src", data);
                document.getElementById("response").innerHTML = data;
            }
        });
    });
</script>

</body>
</html>