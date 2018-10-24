<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 9/13/2018
 * Time: 9:18 PM
 */

class DBHelper
{
    // Members
    private $user;
    private $password;
    private $db;

    /**
     * DBHelper constructor.
     */
    public function __construct()
    {
        $this->user = 'root';
        $this->password = 'TKrEuOL8bWneYLvH';
        $this->db = 'employeemanager';
    }

    public function getConnection()
    {
        return $db = new mysqli('localhost', $this->user, $this->password, $this->db);
    }


    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    // Used to return the latest date_to in the pay_period table
    public function getLatestPayPeiod()
    {
        // Create connection
        $conn = $this->getConnection();
        $data = "";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT MAX(`date_to`) FROM `pay_period`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                $data = $row;
            }
        }
        $conn->close();
        return $data;
    }

    // "SELECT * FROM `time_sheet` WHERE `date` BETWEEN \"$monday\" AND \"$friday\""
    public function getPieChartData($monday, $friday, $employee_id)
    {
        // Create connection
        $conn = $this->getConnection();
        $data = [];

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `time_sheet` WHERE `date` BETWEEN \"$monday\" AND \"$friday\" AND `employee_id` = $employee_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = mysqli_fetch_assoc($result))
            {
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }

    // Used to insert hours
    public function submitHours($hours, $date, $employee_id, $pay_period_id, $timef, $timet)
    {
        // Create connection
        $conn = $this->getConnection();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `time_sheet`(`number_hours`, `time_from`, `time_to`, `date`, `employee_id`, `pay_period_id`) VALUES ($hours, \"$timef\", \"$timet\", \"$date\",$employee_id,(SELECT `pay_period_id` FROM `pay_period` WHERE `date_to` = \"$pay_period_id\"))";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }

        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    // Used to log a user in
    public function authenticateUser($employeeNumber, $password)
    {
        // Create connection
        $conn = $this->getConnection();
        $data = "";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `id`, `first_name`, `last_name`, `employee_number`, `admin` FROM `employee` WHERE `employee_number` = $employeeNumber AND `password` LIKE \"$password\" LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                $data = $row;
            }
        }
        $conn->close();
        return $data;
    }

    // If 0, not a manager. Anything else, they are
    public function checkManager($employeeNumber, $password)
    {
        // Create connection
        $conn = $this->getConnection();
        $manager = 0;

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `dept_manager_ID` FROM `dept_manager` m " .
            "left join `employee` e on e.`id` = m.`employee_id` " .
            "WHERE e.`employee_number` = $employeeNumber AND e.`password` LIKE \"$password\" LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $manager = $row["dept_manager_ID"];
            }
        }

        $conn->close();
        return $manager;
    }

    // Used to obtain user information
    public function signUp($address, $city, $zip, $state, $country, $firstName, $lastName, $gender, $password, $date)
    {
        //Create connection
        $conn = $this->getConnection();
 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `address`(`street_address`, `city`, `zipcode`, `state`, `country`) VALUES (\"$address\", \"$city\", \"$zip\", \"$state\", \"$country\")";

        $resultAdd = $conn->query($sql);

        $sql = "INSERT INTO `employee`(`first_name`, `last_name`, `gender`, `hire_date`, `password`) VALUES (\"$firstName\", \"$lastName\", \"$gender\", \"$date\", \"$password\")";

        $resultEmp = $conn->query($sql);

        if($resultAdd === TRUE && $resultEmp ===TRUE)
        {
            echo "<script>alert(\"Sign up successful\")</script>";
        }
        else
        {
            echo "<script>alert(\"Sign up unsuccessful\")</script>";
        }

        $conn->close();
    }

    // pay_period_id is actually the current date, not the primary key
    public function selectAllTimeSheet($employee_id, $pay_period_id)
    {
        $data = array();
        $to_date = $pay_period_id["MAX(`date_to`)"];

        // Getting connection
        $mysqli = $this->getConnection();

        // Checking to see if the connection failed
        if($mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return false;
        }

        $sql = "SELECT * FROM `time_sheet` WHERE `employee_id` = $employee_id AND `pay_period_id` = (SELECT `pay_period_id` FROM `pay_period` WHERE `date_to` = \"$to_date\")";

        $response = $mysqli->query($sql);

        if ($response)
        {
            while($row = mysqli_fetch_assoc($response))
            {
                $data[] = $row;
            }
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

        $mysqli->close();

        return $data;
    }

    public function updatePayPeriod($to, $from)
    {
        // Create connection
        $conn = $this->getConnection();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `pay_period`(`date_from`, `date_to`) VALUES (\"$from\",\"$to\")";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }

        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function ddlEmployees($manager_id)
    {
        // Getting connection
        $mysqli = $this->getConnection();
        // Checking to see if the connection failed
        if($mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return false;
        }
        // Creating select statement
        $sql = "SELECT `id`, `first_name`, `last_name` FROM `employee` e " .
        "LEFT JOIN `dept_manager` m on m.`employee_id` = e.`id` " .
        "LEFT JOIN `dept_emp` d on d.`employee_id` = e.`id` " .
        "WHERE d.`dept_emp_ID` = $manager_id";

        $result = $mysqli->query($sql);

        if ($result)
        {

            echo "<label for='peopleTagged'>Tag employees</label>";
            echo "<select id = 'peopleTagged' class='form-control' name='peopleTagged'>";
            echo "<option value ='" . -1 . "'>All</option>";

            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $name = $row["first_name"] . " " . $row["last_name"];
                echo "<option value ='" . $row["id"] . "'>"
                    . $name  . "</option>";
            }
            echo "</select>";
        }
        else
        {
            // Closing database connection
            echo "Hey there $manager_id";
            $mysqli->close();
            return false;
        }
        // Closing db connection
        mysqli_close($mysqli);
        return true;
    }
}