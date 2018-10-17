<?php
/**
 * Created by PhpStorm.
 * User: Courtland
 * Date: 10/15/2018
 * Time: 10:01 PM
 */

class SessionManager
{
    // Employee information we need
    private $primarykey;
    private $employeeNumber;
    private $firstName;
    private $lastName;
    private $isManager;
    private $isAdmin;
    private $loggedIn;

    /**
     * SessionManager constructor.
     */
    public function __construct()
    {
        session_start();

        // logging in
        if(isset($_SESSION['primarykey']) && isset($_SESSION['employeeNumber']) && isset($_SESSION['firstName'])
         && isset($_SESSION['lastName']) && isset($_SESSION['isManager']) && isset($_SESSION['isAdmin']))
        {
            // Setting class variables
            $this->setPrimarykey($_SESSION['primarykey']);
            $this->setEmployeeNumber($_SESSION['employeeNumber']);
            $this->setFirstName($_SESSION['firstName']);
            $this->setLastName($_SESSION['lastName']);
            $this->setIsManager($_SESSION['isManager']);
            $this->setIsAdmin($_SESSION['isAdmin']);
            $this->setLoggedIn(true);
        }
    }

    public function loggout()
    {
        // Logging out
        session_destroy();
        $this->setLoggedIn(false);
        header("Location: ../../EmployeeManager/Forms/Login.php");
    }

    // Need static function for the first initiation of this object.
    public static function login($primarykey, $employeeNumber, $firstName, $lastName, $isManager, $isAdmin, $loggedIn)
    {
        // Starting new instance of this class
        $instance = new self();

        // Setting class variables
        $instance->setPrimarykey($primarykey);
        $instance->setEmployeeNumber($employeeNumber);
        $instance->setFirstName($firstName);
        $instance->setLastName($lastName);
        $instance->setIsManager($isManager);
        $instance->setIsAdmin($isAdmin);
        $instance->setLoggedIn(true);

        return $instance;
    }

    /**
     * @return mixed
     */
    public function getPrimarykey()
    {
        return $this->primarykey;
    }

    /**
     * @param mixed $primarykey
     */
    public function setPrimarykey($primarykey)
    {
        $this->primarykey = $primarykey;
    }

    /**
     * @return mixed
     */
    public function getLoggedIn()
    {
        return $this->loggedIn;
    }

    /**
     * @param mixed $loggedIn
     */
    public function setLoggedIn($loggedIn)
    {
        $this->loggedIn = $loggedIn;
    }

    /**
     * @return mixed
     */
    public function getEmployeeNumber()
    {
        return $this->employeeNumber;
    }

    /**
     * @param mixed $employeeNumber
     */
    public function setEmployeeNumber($employeeNumber)
    {
        $this->employeeNumber = $employeeNumber;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getisManager()
    {
        return $this->isManager;
    }

    /**
     * @param mixed $isManager
     */
    public function setIsManager($isManager)
    {
        $this->isManager = $isManager;
    }

    /**
     * @return mixed
     */
    public function getisAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}