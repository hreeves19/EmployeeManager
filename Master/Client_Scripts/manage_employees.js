$(document).ready(function(){
/*    $.ajax({
        url: "../Master/Server_Scripts/ManageEmployeesManager.php",
        method: "post",
        data:{getDataTable: true},
        success:function(data)
        {
            console.log(JSON.parse(data));
        }*/
        showTable();
    });

function showTable() {
    console.log("show table");
    // Creating data table and defining its properties
    var table = $('#dataTable').DataTable({
        "processing": true,
        "serverside": true,
        "lengthMenu": [20, 40, 60, 80, 100],
        "destroy": true,

        // Displaying loading gif
        /*"language": {
            "processing": "<div id='divLoad'><figure id='figLoad'>" +
            "<img src='../../EmployeeManager/Forms/LoadingGifs/loading-gif-1.gif'><figcaption>Loading</figcaption></figure><div>"
        },*/

        "initComplete": function () {
            console.log("Table done loading...");
        },

        // Getting select statement
        ajax:
            {
                url: "../Master/Server_Scripts/ManageEmployeesManager.php?getDataTable=" + true,
            },

        columns: [
            {data: 'id'},
            {data: 'first_name'},
            {data: 'last_name'},
            {data: 'gender'},
            {data: 'hire_date'},
            {data: 'employee_number'},
            {data: 'admin'},
            {data: 'title_id'},
            {data: 'address_id'}
        ]
    });
}