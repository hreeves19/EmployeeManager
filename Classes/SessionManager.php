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
    private $title;
    private $address;
    private $city;
    private $zipcode;
    private $state;
    private $hireDate;
    private $managers_id; // If 0, means employee is not a manager
    private $manager_name; // Managers name, empty if this person is a manager
    private $address_ID;

    /**
     * SessionManager constructor.
     */
    public function __construct()
    {
        session_start();

        // logging in
        if(isset($_SESSION['primarykey']) && isset($_SESSION['employeeNumber']) && isset($_SESSION['firstName'])
         && isset($_SESSION['lastName']) && isset($_SESSION['isManager']) && isset($_SESSION['isAdmin']) && isset($_SESSION['title'])
        && isset($_SESSION['manager_id']) && isset($_SESSION['address']) && isset($_SESSION['hireDate']) && isset($_SESSION['city'])
            && isset($_SESSION['zipcode']) && isset($_SESSION['state']) && isset($_SESSION['address_ID']))
        {
            // Setting class variables
            $this->setPrimarykey($_SESSION['primarykey']);
            $this->setEmployeeNumber($_SESSION['employeeNumber']);
            $this->setFirstName($_SESSION['firstName']);
            $this->setLastName($_SESSION['lastName']);
            $this->setIsManager($_SESSION['isManager']);
            $this->setIsAdmin($_SESSION['isAdmin']);
            $this->setTitle($_SESSION['title']);
            $this->setLoggedIn(true);
            $this->setManagersId($_SESSION['manager_id']);
            $this->setAddress(($_SESSION['address']));
            $this->setHireDate($_SESSION['hireDate']);
            $this->setCity($_SESSION['city']);
            $this->setZipcode($_SESSION['zipcode']);
            $this->setState($_SESSION['state']);
            $this->setAddressId($_SESSION['address_ID']);

            // Checking if manager name is set
            if(isset($_SESSION['manager_name']))
            {
                $this->setManagerName($_SESSION['manager_name']);
            }

            else
            {
                // Give it nothing
                $this->setManagerName("");
            }
        }
    }

    public function loggout()
    {
        // Logging out
        session_destroy();
        $this->setLoggedIn(false);
        header("Location: ../../EmployeeManager/Forms/Login.php");
    }

    /**
     * @return mixed
     */
    public function getAddressID()
    {
        return $this->address_ID;
    }

    /**
     * @param mixed $address_ID
     */
    public function setAddressID($address_ID)
    {
        $this->address_ID = $address_ID;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getManagerName()
    {
        return $this->manager_name;
    }

    /**
     * @param mixed $manager_name
     */
    public function setManagerName($manager_name)
    {
        $this->manager_name = $manager_name;
    }

    /**
     * @return mixed
     */

    public function getHireDate()
    {
        return $this->hireDate;
    }

    /**
     * @param mixed $hireDate
     */
    public function setHireDate($hireDate)
    {
        $this->hireDate = $hireDate;
    }

    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */

    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */

    public function getManagersId()
    {
        return $this->managers_id;
    }

    /**
     * @param mixed $managers_id
     */

    public function setManagersId($manager_id)
    {
        // Checking to see if employee is a manager
        if( $this->getisManager() === false)
        {
            $this->managers_id = $manager_id;
        }

        else
        {
            $this->managers_id = 0;
        }
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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