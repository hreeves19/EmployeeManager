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
        $this->setSql();
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

    public function authenticateUser($username, $password)
    {

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