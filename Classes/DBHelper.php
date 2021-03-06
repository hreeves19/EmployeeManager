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

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param string $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }


    public function getConnection()
    {
        return $db = new mysqli('localhost', $this->user, $this->password, $this->db);
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

        /*        $sql = "SELECT `id`, `first_name`, `last_name`, `employee_number`, `admin` FROM `employee` WHERE `employee_number` = $employeeNumber AND `password` LIKE \"$password\" LIMIT 1";*/
        $sql = "SELECT e.`id`, e.`first_name`, e.`last_name`, e.`employee_number`, e.`admin`, e.`hire_date`, a.`address_ID`, a.`street_address`, a.`city`, a.`zipcode`, a.`state`, t.`title`, s.`salary_per_hour` FROM `employee` e ".
            "left join `address` a on a.`address_ID` = e.`address_id`".
            "left join `titles` t on t.`title_id` = e.`title_id`".
            "left join `salaries` s on s.`title_id` = t.`title_id`".
            "WHERE e.`employee_number` = $employeeNumber AND e.`password` LIKE \"$password\" LIMIT 1";
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
    public function selectAllTimeSheet($employee_id, $pay_period_id, $flag)
    {
        $data = array();

        // Getting connection
        $mysqli = $this->getConnection();

        // Checking to see if the connection failed
        if($mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return false;
        }

        // If given pay period by primary key
        if($flag)
        {
            $sql = "SELECT * FROM `time_sheet` WHERE `employee_id` = $employee_id AND `pay_period_id` = $pay_period_id";
        }

        else
        {
            $to_date = $pay_period_id["MAX(`date_to`)"];
            $sql = "SELECT * FROM `time_sheet` WHERE `employee_id` = $employee_id AND `pay_period_id` = (SELECT `pay_period_id` FROM `pay_period` WHERE `date_to` = \"$to_date\")";

        }

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

    // This is for a form
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

    // This is if you just want the drop down list, this is for the manage employees dashboard
    public function ddlGetEmployees($manager_id)
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
            "WHERE d.`dept_manager_ID` = $manager_id";

        $result = $mysqli->query($sql);

        if ($result)
        {
            echo "Employees <select id='ddlEmployees' onchange='showNewCalendar()' class='form-control'>";
            //echo "<option value ='" . -1 . "'>Unselected</option>";

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

    public function addEvent($name, $startTime, $endTime, $description, $mandatory, $deptManager, $date, $dateEnd)
    {
        // Create connection
        $conn = $this->getConnection();


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `event`(`date`, `date_end`, `name`, `start_time`, `end_time`, `description`, `mandatory`, `dept_manager_ID`) VALUES (\"$date\",\"$dateEnd\",\"$name\",\"$startTime\",\"$endTime\",\"$description\",$mandatory,$deptManager)";

        echo $sql;

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }

        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function updateEvent($name, $startTime, $endTime, $description, $mandatory, $deptManager, $date, $dateEnd, $id)
    {
        // Create connection
        $conn = $this->getConnection();


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE `event` SET `event_id`=$id,`date`=\"$date\", `date_end` = \"$dateEnd\",`name`=\"$name\",`start_time`=\"$startTime\",`end_time`=\"$endTime\",`description`=\"$description\",`mandatory`=$mandatory,`dept_manager_ID`=$deptManager WHERE `event_id` = $id";

        echo $sql;

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }

        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function deleteEvent($id)
    {
        // Create connection
        $conn = $this->getConnection();


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM `event` WHERE `event_id` = $id";

        echo $sql;

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }

        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function getEvents($deptManager)
    {
        $data = array();

        // Getting connection
        $mysqli = $this->getConnection();

        // Checking to see if the connection failed
        if($mysqli->connect_errno)
        {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            return false;
        }

        $sql = "SELECT * FROM `event` WHERE `dept_manager_ID` = $deptManager";

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

    public function getEmployeesManager($employee_primary_key)
    {
        // Create connection
        $conn = $this->getConnection();
        $data = "";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `dept_manager_id` FROM `dept_emp` WHERE `employee_id` = $employee_primary_key";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                $data = $row;
            }
        }
        echo $employee_primary_key . " pk";
        $conn->close();
        return $data;
    }

    public function getEmployeeManagerName($dept_manager_ID)
    {
        // Create connection
        $conn = $this->getConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `first_name`, `last_name` FROM `employee` e
        left join `dept_manager` d on d.`employee_id` = e.`id`
        WHERE d.`dept_manager_ID` = $dept_manager_ID LIMIT 1";
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

    public function imageUpload($target_dir, $file_name, $eNumber)
    {
        // connect to database
        $cdb = $this->getConnection();

        $filePath = $target_dir.$file_name;

        // query
        $q = "UPDATE `employee` SET `image`= \"$filePath\" WHERE `employee_number` = $eNumber";

        // run query
        $r = mysqli_query($cdb,$q);

        if(mysqli_affected_rows($cdb) == 1)
        {
            echo "<p style='color:green'><b>File has been successfully uploaded</b></p>";
        }
        else
        {
            echo "<p>A system error has been occured</p>".mysqli_error($cdb);
        }

        // Make sure you always close the connection
        $cdb->close();
    }

    public function getImage($eNumber)
    {
        // Create connection
        $conn = $this->getConnection();
        $data = "";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        /*        $sql = "SELECT `id`, `first_name`, `last_name`, `employee_number`, `admin` FROM `employee` WHERE `employee_number` = $employeeNumber AND `password` LIKE \"$password\" LIMIT 1";*/
        $sql = "SELECT `image` FROM `employee` WHERE `employee_number` = $eNumber";
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

    public function getEmployees($manager_id)
    {
        // Create connection
        $conn = $this->getConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        /*        $sql = "SELECT `id`, `first_name`, `last_name`, `employee_number`, `admin` FROM `employee` WHERE `employee_number` = $employeeNumber AND `password` LIKE \"$password\" LIMIT 1";*/
        $sql = "SELECT `id`, `first_name`, `last_name`,`gender`, `hire_date`, `employee_number`, `admin`, t.`title`, a.`street_address` FROM `employee` e 
        left join `dept_emp` d on d.`employee_id` = e.`id`
        left join `dept_manager` m on m.`employee_id` = e.`id`
        left join `address` a on a.`address_ID` = e.`address_id`
        left join `titles` t on t.`title_ID` = e.`title_id`
        WHERE d.`dept_manager_id` = $manager_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                $data[] = $row;
            }
        }

        $conn->close();
        return $data;
    }

    // This function is used to update the approved value in the timesheet table
    public function updateTimesheetApproved($employee_id, $status)
    {

        // connect to database
        $cdb = $this->getConnection();

        // Using flag to determine if there was an error
        $flag = false;

        // query
        $q = "UPDATE `time_sheet` SET `approved`= $status WHERE `employee_id` = $employee_id";
        echo $q;

        // run query
        $r = mysqli_query($cdb,$q);

        if(mysqli_affected_rows($cdb) == 1)
        {
            $flag = true;
        }
        else
        {
            echo "<p>A system error has been occured</p>".mysqli_error($cdb);
        }

        // Make sure you always close the connection
        $cdb->close();
        return $flag;
    }

    // Select all function
    public function getAllTable($table, $where)
    {
        $flag = false;

        // Checking to make sure table is set
        if(empty($table))
        {
            echo "You need to give the table that you want to select from.";
            return false;
        }

        if(empty($where) )
        {
            $flag = true;
        }

        // Create connection
        $conn = $this->getConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Include where statement if the where is set
        if($where == false)
        {
            $sql = "SELECT * FROM `$table`";
        }

        else
        {
            $sql = "SELECT * FROM `$table` WHERE $where";
        }

        $result = $conn->query($sql);

        // Checking to see if the query returns anything
        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                $data[] = $row;
            }
        }

        $conn->close();
        return $data;
    }

    public function getDDLPayPeriod()
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
        $sql = "SELECT * FROM `pay_period` ORDER BY `pay_period_id` DESC";

        $result = $mysqli->query($sql);

        if ($result)
        {
            echo "Pay period <select id='ddlPayPeriod' onchange='showNewCalendar()' class='form-control'>";
            //echo "<option value ='" . -1 . "'>Unselected</option>";

            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $show = $row["date_from"] . " to " . $row["date_to"];
                echo "<option value ='" . $row["pay_period_id"] . "'>"
                    . $show  . "</option>";
            }
            echo "</select>";
        }
        else
        {
            // Closing database connection
            echo "Cannot show list of pay periods.";
            $mysqli->close();
            return false;
        }
        // Closing db connection
        mysqli_close($mysqli);
        return true;
    }

    public function updateProfile($address, $city, $zip, $State, $address_ID)
    {
        // connect to database
        $cdb = $this->getConnection();

        // Using flag to determine if there was an error
        $flag = false;

        // query
        $q = "UPDATE `address` SET `street_address`=\"$address\",`city`=\"$city\",`zipcode`=$zip,`state`=\"$State\" WHERE `address_ID` = $address_ID";

        //echo $q;
        // run query
        $r = mysqli_query($cdb,$q);

        if(mysqli_affected_rows($cdb) == 1)
        {
            $flag = true;
        }
        else
        {
            echo "<p>A system error has been occured</p>".mysqli_error($cdb);
        }

        // Make sure you always close the connection
        $cdb->close();
        return $flag;
    }
}