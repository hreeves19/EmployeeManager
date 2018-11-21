$( document ).ready(function()
{
    $("#formProfile").submit(function(){
        $("#Address").prop("readonly", true);
        $("#city").prop("readonly", true);
        $("#State").prop("readonly", true);
        $("#zipcode").prop("readonly", true);
        $("#submitBtn").prop("disabled", true);
        $("#editBtn").prop("disabled", false);

        // Get textboxes values store it in a variable
        var address = document.getElementById("Address").value;
        var city = document.getElementById("city").value;
        var zip = document.getElementById("zipcode").value;
        var state = document.getElementById("State").value;

        //ajax call
        $.ajax({
            url: "../../EmployeeManager/Master/Server_Scripts/ProfilePageManager.php",
            method: "post",
            data: {UPDATE: true, Address: address, city: city, zipcode: zip, State: state},
            success: function(data){
                console.log(data);
            }
        });

        return false;
    });
});

function editButton()
{
    $("#Address").prop("readonly", false);
    $("#city").prop("readonly", false);
    $("#State").prop("readonly", false);
    $("#zipcode").prop("readonly", false);
    $("#submitBtn").prop("disabled", false);
    $("#editBtn").prop("disabled", true);
}
