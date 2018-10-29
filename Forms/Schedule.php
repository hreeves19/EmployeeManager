<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/22/2018
 * Time: 9:24 PM
 */
// ADD THIS SECTION ON EVERY PAGE EXCEPT LOGIN
// This helps us keep track of the user
/****************************************************************************/
require('../../EmployeeManager/Classes/SessionManager.php');
require('../../EmployeeManager/Classes/DBHelper.php');

$DB = new DBHelper();

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

    <title>My Schedule</title>

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
    <?php include("../Master/sidenavbar.php") ?>

    <div id="content-wrapper">
        <div class="container-fluid">

            <label for="managerid" style="display: none;"></label>
            <input type="text" style="display: none;" id="managerid" value=<?php echo json_encode($session->getManagersId()) ?>>

            <!-- Calendar -->
            <div class="card ml-lg-5">
                <div class="card-header">
                    <h1 style="text-align: center;">My Schedule</h1>
                </div>
                <div class="card-body">
                    <div id='calendar' style="padding: 10px;"></div>
                </div>
            </div>
            <br>

            <!-- Add Event Modal -->
            <div class="modal fade" id="eventModal" aria-labelledby="eventModal" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-simple" id="myModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="eventModal">Add Event</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addEventModalForm">
                                <div class="row">
                                    <div class="col-xl-4 form-group">
                                        <label for="eventName" style="text-align: center;">Event Name</label>
                                        <input type="text" class="form-control" name="eventName" placeholder="Event Name" id="eventName" required="required">
                                    </div>
                                    <div class="col-xl-4 form-group">
                                        <label for="eventStart">Event Starts</label>
                                        <input id="eventStart" type="time" name="eventStart" class="form-control" placeholder="Event Starts" required="required">
                                    </div>
                                    <div class="col-xl-4 form-group">
                                        <label for="eventEnd">Event Ends</label>
                                        <input id="eventEnd" type="time" name="eventEnd" class="form-control" placeholder="Event Ends" required="required">
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <?php $DB->ddlEmployees($session->getisManager()); ?>
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <label for="mandatory">Mandatory</label>
                                        <select id="mandatory" name="mandatory" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <textarea id="eventDescription" name="eventDescription" class="form-control" rows="5" placeholder="Type event description"></textarea>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <label for="date">Day of Event</label>
                                        <input id="date" type="text" name="date" class="form-control" placeholder="Day of Event" readonly>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button class="btn btn-primary btn-outline" type="submit" id="btnSubmit" name="btnSubmit" data-toggle="modal" data-target="#myModal">Add Event</button>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-outline" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Event Modal for days -->
            <div class="modal fade" id="eventModalSelect" aria-labelledby="eventModalSelect" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-simple">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="eventModalSelect">Add Event</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addEventModalFormSelect">
                                <div class="row">
                                    <div class="col-xl-4 form-group">
                                        <label for="eventNameSelect" style="text-align: center;">Event Name</label>
                                        <input type="text" class="form-control" name="eventNameSelect" placeholder="Event Name" id="eventName" required="required">
                                    </div>
                                    <div class="col-xl-4 form-group">
                                        <label for="eventStartSelect">Event Starts</label>
                                        <input id="eventStartSelect" type="time" name="eventStartSelect" class="form-control" placeholder="Event Starts" required="required">
                                    </div>
                                    <div class="col-xl-4 form-group">
                                        <label for="eventEndSelect">Event Ends</label>
                                        <input id="eventEndSelect" type="time" name="eventEndSelect" class="form-control" placeholder="Event Ends" required="required">
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <?php $DB->ddlEmployees($session->getisManager()); ?>
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <label for="mandatorySelect">Mandatory</label>
                                        <select id="mandatorySelect" name="mandatorySelect" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <textarea id="eventDescriptionSelect" name="eventDescriptionSelect" class="form-control" rows="5" placeholder="Type event description"></textarea>
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <label for="dateSelectStart">Day Event Starts</label>
                                        <input id="dateSelectStart" type="text" name="dateSelectStart" class="form-control" placeholder="Day of Event" readonly>
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <label for="dateSelectEnd">Day Event Ends</label>
                                        <input id="dateSelectEnd" type="text" name="dateSelectEnd" class="form-control" placeholder="Day of Event" readonly>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button class="btn btn-primary btn-outline" type="submit" id="btnSubmitSelect" name="btnSubmitSelect" data-toggle="modal" data-target="#myModal">Add Event</button>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-outline" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Event Modal -->
            <div class="modal fade" id="editModal" aria-labelledby="editModal" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-simple" id="myModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Event</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editEventModalForm">
                                <div class="row">
                                    <div class="col-xl-4 form-group">
                                        <label for="eventNameEdit" style="text-align: center;">Event Name</label>
                                        <input type="text" class="form-control" name="eventNameEdit" placeholder="Event Name" id="eventNameEdit" required="required">
                                    </div>
                                    <div class="col-xl-4 form-group">
                                        <label for="eventStartEdit">Event Starts</label>
                                        <input id="eventStartEdit" type="time" name="eventStartEdit" class="form-control" placeholder="Event Starts" required="required">
                                    </div>
                                    <div class="col-xl-4 form-group">
                                        <label for="eventEndEdit">Event Ends</label>
                                        <input id="eventEndEdit" type="time" name="eventEndEdit" class="form-control" placeholder="Event Ends" required="required">
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <?php $DB->ddlEmployees($session->getisManager()); ?>
                                    </div>
                                    <div class="col-xl-6 form-group">
                                        <label for="mandatoryEdit">Mandatory</label>
                                        <select id="mandatoryEdit" name="mandatoryEdit" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <textarea id="eventDescriptionEdit" name="eventDescriptionEdit" class="form-control" rows="5" placeholder="Type event description"></textarea>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <label for="dateEdit">Day of Event</label>
                                        <input id="dateEdit" type="text" name="dateEdit" class="form-control" placeholder="Day of Event" readonly>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button class="btn btn-primary btn-outline" type="submit" id="btnSubmitEdit" name="btnSubmitEdit" data-toggle="modal" data-target="#myModal">Update Event</button>
                                </div>
                                <div class="float-right">
                                    <button class="btn btn-primary btn-outline" type="submit" id="btnDeleteEvent" name="btnDeleteEvent" data-toggle="modal" data-target="#myModal">Delete Event</button>
                                </div>
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
                    <span>Copyright © Your Website 2018</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->

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

<!-- Core plugin JavaScript-->
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/js/sb-admin.min.js"></script>

<!-- For Chart -->
<!-- Page level plugin JavaScript-->
<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/chart.js/Chart.min.js"></script>

<!-- Open Source FullCalendar Javascript library -->
<!-- https://fullcalendar.io/ -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css" rel="stylesheet" type="text/css">-->
<link href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
<link href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/jquery.min.js'></script>
<script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js'></script>
<script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/gcal.min.js'></script>

<script src="../../EmployeeManager/Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>

<!-- Our script files -->
<script src="../../EmployeeManager/Master/Client_Scripts/schedule_calendar_manager.js"></script>


</body>
</html>


