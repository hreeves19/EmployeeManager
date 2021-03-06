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

            <h1 style="text-align: center">Profile</h1>
            <hr>

            <!-- Put Page contents here -->

            <div class="row" style="padding-top: 10px;">

                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">Profile Image</div>
                        <div class="card-body">

                            <img src="" id="path">
                            <div id="response"></div>
                            <br>

                            <form action="../../EmployeeManager/Master/Server_Scripts/ProfilePageManager.php" method="post" enctype="multipart/form-data">
                                <p>
                                    File : <input type="file" name="upload">
                                </p>
                                <input type="submit" value="upload file">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">Profile Content</div>
                            <div   class="card-body">

                                <form id="formProfile" accept-charset="UTF-8">

                                    <!-- Employee Number Display -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <input id="empNum" type="text" name="empNum" class="form-control" placeholder="Employee Number" required="required" value="<?php echo $session->getEmployeeNumber(); ?>" readonly>
                                            <label for="empNum">Employee Number</label>
                                        </div>
                                    </div>

                                    <!-- First and Last Name Row Display -->
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

                                    <!-- Title and hire date Row Display -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input id="title" type="text" name="title" class="form-control" placeholder="title" required="required" value="<?php echo $session->getTitle(); ?>" readonly>
                                                    <label for="title">Title</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input id="hireDate" type="text" name="hireDate" class="form-control" placeholder="Hire Date" required="required" value="<?php echo $session->getHireDate(); ?>" readonly>
                                                    <label for="hireDate">Hire Date</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address display -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <input id="Address" type="text" name="Address" class="form-control" placeholder="Address" required="required" value="<?php echo $session->getAddress(); ?>" readonly>
                                            <label for="Address">Address</label>
                                        </div>
                                    </div>

                                    <!-- City, State, and Zip Code Row Display -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-5">
                                                <div class="form-label-group">
                                                    <input id="city" type="text" name="city" class="form-control" placeholder="City" required="required" value="<?php echo $session->getCity(); ?>" readonly>
                                                    <label for="city">City</label>
                                                </div>
                                            </div>

                                            <!-- State Drop Down box -->
                                            <div class="col-md-2">
                                                <div class="form-label-group">
                                                    <label for="State"></label>
                                                    <select class="form-control" name="State" id="State" required="required" readonly="readonly">
                                                        <option value="AL">Alabama</option>
                                                        <option value="AK">Alaska</option>
                                                        <option value="AZ">Arizona</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="CA">California</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="HI">Hawaii</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WA">Washington</option>
                                                        <option value="WV">West Virginia</option>
                                                        <option value="WI">Wisconsin</option>
                                                        <option value="WY">Wyoming</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-label-group">
                                                    <input id="zipcode" type="text" name="zipcode" class="form-control" placeholder="Zip Code" required="required" value="<?php echo $session->getZipcode(); ?>" readonly>
                                                    <label for="zipcode">Zip Code</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="editBtn" class="btn btn-primary btn-block" onclick="editButton()">Edit</button>
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-block" disabled>Submit</button>
                                </form>
                            </div>
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

<!-- javascript file -->
<script src="../../EmployeeManager/Master/Client_Scripts/Profile_Manager.js"></script>
<script>
    document.getElementById("State").value = "<?php echo $session->getState(); ?>";
</script>

</body>
</html>