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
    private $sql;

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
     * @param mixed $sql
     */
    public function setSql()
    {
        $this->sql = $this->getConnection();
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    // Used to log a user in
    public function authenticateUser($employeeNumber, $password)
    {
        // Create connection
        $conn = $this->getConnection();
        $firstname = "";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `id`, `first_name` FROM `employee` WHERE `employee_number` = $employeeNumber AND `password` LIKE \"$password\" LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $firstname = $row["first_name"];
                $empid = $row["id"];
            }
        }
        $conn->close();
        return $firstname;
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

    public function getUsername()
    {
        // Create connection
        $conn = $this->sql;
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `employee`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
}