$(document).ready(function(){
    $.ajax({
        url: "../Master/Server_Scripts/ManagerEmployeesManager.php",
        method: "post",
        data:{getDataTable: true},
        success:function(data)
        {
            console.log(data);
        }
    });

});