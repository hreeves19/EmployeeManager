$( document ).ready(function()
{
    $("#formProfile").submit(function(){
        $("#Address").prop("readonly", true);
        $("#city").prop("readonly", true);
        $("#state").prop("readonly", true);
        $("#zipcode").prop("readonly", true);
        $("#submitBtn").prop("disabled", true);
        $("#editBtn").prop("disabled", false);
        return false;
    });


});

function editButton()
{
    $("#Address").prop("readonly", false);
    $("#city").prop("readonly", false);
    $("#state").prop("readonly", false);
    $("#zipcode").prop("readonly", false);
    $("#submitBtn").prop("disabled", false);
    $("#editBtn").prop("disabled", true);
}