<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 10/18/2018
 * Time: 5:08 PM
 */





?>

<!-- Bootstrap core JavaScript-->
<script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/datatables/jquery.dataTables.js"></script>
<script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="../Master/Bootstrap_Template/startbootstrap-sb-admin-gh-pages/js/sb-admin.min.js"></script>

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
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Time Sheet Table</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>time_id</th>
                    <th>number_hours</th>
                    <th>time_from</th>
                    <th>time_to</th>
                    <th>date</th>
                    <th>employee_id</th>
                    <th>pay_period_id</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>time_id</th>
                    <th>number_hours</th>
                    <th>time_from</th>
                    <th>time_to</th>
                    <th>date</th>
                    <th>employee_id</th>
                    <th>pay_period_id</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Your Time Log</div>
</div>
