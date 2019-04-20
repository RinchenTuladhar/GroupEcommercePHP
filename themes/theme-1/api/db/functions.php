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

    public function getUserByEmail($email, $websiteID){
        $query = $this->conn->prepare("SELECT * FROM users WHERE Email = ? AND WebsiteID = ?");
        $query->bind_param("ss", $email, $websiteID);
        $query->execute();
        $result  = $query->get_result()->fetch_assoc();
        $query->close();
        return $result;
    }

    public function createCustomer($firstName, $lastName, $email, $password, $websiteID)
    {
        $timestamp = time();
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->conn->prepare("INSERT INTO users(Email, FirstName, LastName, EncryptedPassword, WebsiteID, Admin, Timestamp) VALUES(?, ?, ?, ?, ?, 0, ?)");
        $query->bind_param("ssssss", $email, $firstName, $lastName, $encryptedPassword, $websiteID, $timestamp);
        $result = $query->execute();
        $query->close();

        return $result;
    }

    public function updateCustomer($firstName, $lastName, $oldEmail, $email, $websiteID){
        $query = $this->conn->prepare("UPDATE users SET FirstName = ?, LastName = ?, Email = ? WHERE Email = ? AND Admin = 0 AND WebsiteID = ?");
        $query->bind_param("sssss", $firstName, $lastName, $email, $oldEmail, $websiteID);
        var_dump("UPDATE users SET FirstName = $firstName, LastName = $lastName, Email = $email WHERE Email = $oldEmail AND Admin = 0 AND WebsiteID = $websiteID");
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

        $query = $this->conn->query("SELECT * FROM categories WHERE WebsiteID = '$websiteID' AND Navigation = 1 ORDER BY NavOrder ASC");
        return $query;
    }


    public function getCategoryProducts($websiteID, $subcategory)
    {
        $query = $this->conn->prepare("SELECT * FROM products WHERE WebsiteID = ? AND SubCategory = ?");
        $query->bind_param('ss', $websiteID, $subcategory);
        $query->execute();
        $result = $query->get_result();

        $query->close();

        return $result;
    }
    
    public function getParentCategory($websiteID, $subCategory){
        $query = $this->conn->prepare("SELECT Category FROM subcategory WHERE SubCategory = ? AND WebsiteID = ?");
        $query->bind_param("ss", $subCategory, $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        
        return $result;
    }

    public function getItemInformation($websiteID, $itemID)
    {
        $query = $this->conn->prepare("select * from products WHERE ProductID = ?");
        $query->bind_param("s", $itemID);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();

        $query->close();

        return $result;
    }

    public function addToBasket($websiteID, $userEmail, $productID, $quantity)
    {

        $query = $this->conn->prepare("SELECT COUNT(*) As count FROM cart WHERE WebsiteID = ? AND UserEmail = ? AND ProductID = ?");
        $query->bind_param("sss", $websiteID, $userEmail, $productID);
        $query->execute();

        $result = $query->get_result()->fetch_assoc();
        $query->close();

        if ($result["count"] > 0) {
            $query = $this->conn->prepare("UPDATE cart SET Quantity = Quantity + ? WHERE WebsiteID = ? AND UserEmail = ? AND ProductID = ?");
            $query->bind_param("ssss", $quantity, $websiteID, $userEmail, $productID);
            $query->execute();
        } else {
            $query = $this->conn->prepare("INSERT INTO cart VALUES(?,?,?,?)");
            $query->bind_param("ssss", $websiteID, $userEmail, $productID, $quantity);
            $query->execute();
            $query->close();
        }

    }

    public function addSharedBasket($userEmail, $sharedEmail, $websiteID){
        $query = $this->conn->prepare("UPDATE users SET SharedBasket = ? WHERE Email = ? AND WebsiteID = ?");
        $query->bind_param("sss", $userEmail, $sharedEmail, $websiteID);
        $result = $query->execute();
        $query->close();

        return $result;
    }


    public function getBasket($userEmail, $websiteID)
    {
        $query = $this->conn->prepare("SELECT * FROM cart WHERE WebsiteID = ? AND UserEmail = ?");
        $query->bind_param("ss", $websiteID, $userEmail);
        $query->execute();

        $result = $query->get_result();

        $query->close();

        return $result;
    }

    public function checkOut($orderID, $productID, $quantity, $email, $websiteID){
        $time = time();

        $query = $this->conn->prepare("INSERT INTO orderdetails VALUES(?, ?, ?)");
        $query->bind_param("sss", $orderID, $productID, $quantity);
        $query->execute();

        $query->close();

        $query = $this->conn->prepare("INSERT INTO orders VALUES(?, ?, ?, ?)");
        $query->bind_param("ssss", $orderID, $email, $time, $websiteID);
        $query->execute();
        $query->close();

        $query = $this->conn->prepare("UPDATE products SET stock = (stock - $quantity) WHERE WebsiteID = ?
AND ProductID = ?");
        $query->bind_param("ss", $websiteID, $productID);
        $query->execute();
        $query->close();

    }

    public function clearBasket($websiteID, $userEmail){
        $query = $this->conn->prepare("DELETE FROM cart WHERE WebsiteID = ? AND UserEmail = ?");
        $query->bind_param("ss", $websiteID, $userEmail);
        $query->execute();
        $query->close();
    }

    public function getMyOrders($email, $websiteID){
        $query = $this->conn->prepare("SELECT * FROM orders WHERE Email = ? AND WebsiteID = ?");
        $query->bind_param("ss", $email, $websiteID);
        $query->execute();
        $result = $query->get_result();

        $query->close();

        return $result;
    }

    public function getOrderDetails($orderID){
        $query = $this->conn->prepare("SELECT ProductID, Quantity FROM orderdetails WHERE OrderID = ?");
        $query->bind_param("s", $orderID);
        $query->execute();
        $result = $query->get_result();

        $query->close();

        return $result;
    }

    public function getSubCategories($category, $websiteID){
        $query = $this->conn->query("SELECT * FROM subcategory WHERE Category = '$category' AND WebsiteID = '$websiteID'");
        return $query;

    }

    public function getContent($websiteID, $category, $subCategory){
        $query = $this->conn->prepare("SELECT Content FROM pages WHERE WebsiteID = ? AND Category = ? AND SubCategory = ?");
        $query->bind_param("sss", $websiteID, $category, $subCategory);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        return $result;
    }
}

?>