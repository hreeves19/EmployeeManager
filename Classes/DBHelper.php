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
}