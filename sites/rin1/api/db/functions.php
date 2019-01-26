<?php

class Functions
{

    private $conn;

    // constructor
    function __construct()
    {
        require 'conn.php';
        // connecting to database
        $db = new Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct()
    {

    }

    public function getWebsiteID($websiteName)
    {
        $query = $this->conn->prepare("SELECT * FROM websites WHERE DomainName = ?");
        $query->bind_param("s", $websiteName);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();

        $query->close();
        return $result;

    }

    public function createCustomer($firstName, $lastName, $email, $password, $websiteID)
    {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->conn->prepare("INSERT INTO users(Email, FirstName, LastName, EncryptedPassword, WebsiteID, Admin) VALUES(?, ?, ?, ?, ?, 0)");
        $query->bind_param("sssss", $email, $firstName, $lastName, $encryptedPassword, $websiteID);
        $result = $query->execute();
        $query->close();

        return $result;
    }

    public function checkPassword($email, $password, $websiteID)
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE Email = ? AND WebsiteID = ?");
        $query->bind_param("ss", $email, $websiteID);
        $query->execute();

        $user = $query->get_result()->fetch_assoc();

        $query->close();

        if (password_verify($password, $user["EncryptedPassword"])) {
            return $user;
        } else {
            return null;
        }
    }

    public function hasDomainName($websiteID)
    { // Checks to see if user has named their domain
        $query = $this->conn->prepare("SELECT * FROM websites WHERE WebsiteID = ?");
        $query->bind_param('s', $websiteID);
        $query->execute();

        $hasDomain = $query->get_result()->fetch_assoc();

        $query->close();

        return $hasDomain;
    }

    public function createDomainName($domain, $websiteID)
    {
        $query = $this->conn->prepare("SELECT * FROM websites WHERE DomainName = ?");
        $query->bind_param('s', $domain);
        $query->execute();

        $oldDomain = $query->get_result()->fetch_assoc();

        $query->close();

        if ($oldDomain == null) {
            $query = $this->conn->prepare("UPDATE websites SET DomainName = ? WHERE WebsiteID = ?");
            $query->bind_param('ss', $domain, $websiteID);
            $query->execute();
            $query->close();
        }

        return $query;
    }

    public function getCategoryNavigation($websiteName)
    {
        $query = $this->conn->prepare("SELECT WebsiteID FROM websites WHERE DomainName = ?");
        $query->bind_param('s', $websiteName);
        $query->execute();

        $websiteID = $query->get_result()->fetch_assoc();
        $websiteID = $websiteID["WebsiteID"];
        $query->close();

        $query = $this->conn->query("SELECT * FROM categories WHERE WebsiteID = '$websiteID' AND Navigation = 1");
        return $query;
    }


    public function getCategoryProducts($websiteID, $category)
    {
        $query = $this->conn->prepare("SELECT * FROM products WHERE WebsiteID = ? AND Category = ?");
        $query->bind_param('ss', $websiteID, $category);
        $query->execute();
        $result = $query->get_result();

        $query->close();

        return $result;
    }

    public function getItemInformation($websiteID, $itemID){
        $query = $this->conn->prepare("select * from products WHERE ProductID = ?");
        $query->bind_param("s", $itemID);
        $query->execute();
        $result = $query->get_result();

        $query->close();

        return $result;
    }

    public function addToBasket($websiteID, $userEmail, $productID, $quantity){

        $query = $this->conn->prepare("SELECT COUNT(*) As count FROM cart WHERE WebsiteID = ? AND UserEmail = ? AND ProductID = ?");
        $query->bind_param("sss", $websiteID, $userEmail, $productID);
        $query->execute();

        $result = $query->get_result()->fetch_assoc();
        $query->close();

        if($result["count"] > 0){

        } else {
            $query = $this->conn->prepare("INSERT INTO cart VALUES(?,?,?,?)");
            $query->bind_param("ssss", $websiteID, $userEmail, $productID, $quantity);
            $query->execute();
            $query->close();
        }

    }
}

?>