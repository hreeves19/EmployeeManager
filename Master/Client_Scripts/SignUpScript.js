$( document ).ready(function()
{
    getDDLTitle();
});

function getDDLTitle()
{
    // Making a request to the server to get the pay period
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "../../EmployeeManager/Master/Server_Scripts/SignUpManager.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("getDDLTitle=" + true);
}