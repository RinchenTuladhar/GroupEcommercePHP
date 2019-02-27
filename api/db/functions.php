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

    public function createAdmin($firstName, $lastName, $email, $password)
    {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        $websiteID = md5(uniqid($email, true));

        $query = $this->conn->prepare("INSERT INTO websites(WebsiteID, OwnerEmail, DomainName) VALUES(?, ?, null)");
        $query->bind_param("ss", $websiteID, $email);
        $query->execute();
        $query->close();

        $query = $this->conn->prepare("INSERT INTO users(Email, FirstName, LastName, EncryptedPassword, WebsiteID, Admin) VALUES(?, ?, ?, ?, ?, 1)");
        $query->bind_param("sssss", $email, $firstName, $lastName, $encryptedPassword, $websiteID);
        $result = $query->execute();
        $query->close();

        return $result;
    }

    public function checkPassword($email, $password)
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE Email = ?");

        $query->bind_param('s', $email);
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

    public function createCategory($category, $websiteID)
    {
        $str_arr = explode(",", $category);
        $sqlStatement = "INSERT INTO categories(Title, WebsiteID, SubCategory) VALUES ";

        for ($i = 0; $i < sizeof($str_arr); $i++) {
            if ($i == (sizeof($str_arr) - 1)) {
                $sqlStatement .= "('" . str_replace(' ', '', $str_arr[$i]) . "' , '" . $websiteID . "');";
            } else {
                $sqlStatement .= "('" . str_replace(' ', '', $str_arr[$i]) . "' , '" . $websiteID . "');";
            }
        }

        echo $sqlStatement;
        $query = $this->conn->prepare($sqlStatement);
        $query->execute();

        $query->close();

        return $query;
    }

    public function createSubCategory($category, $websiteID, $subCategory)
    {
        $query = $this->conn->prepare("INSERT INTO subcategory(Category, WebsiteID, SubCategory) VALUES(?, ?, ?)");
        $query->bind_param('sss', $category, $websiteID, $subCategory);

        $result = $query->execute();
        $query->close();
        return $result;
    }

    public function getCategories($websiteID)
    {
        $query = $this->conn->query("SELECT * FROM categories WHERE WebsiteID = '$websiteID'");
        return $query;
    }

    public function getSubCategories($category, $websiteID)
    {
        $query = $this->conn->query("SELECT * FROM subcategory WHERE Category = '$category' AND WebsiteID = '$websiteID'");
        return $query;

    }

    public function setWebsiteTheme($websiteID, $theme)
    {
        $query = $this->conn->prepare("UPDATE websites SET Theme = ? WHERE WebsiteID = ?");
        $query->bind_param('ss', $theme, $websiteID);
        $query->execute();
        $query->close();

        return $query;
    }

    public function setNavigationMode($websiteID, $title, $mode)
    {
        $newMode = null;
        if ($mode == "0") {
            $newMode = 1;
        } else {
            $newMode = 0;
        }
        $query = $this->conn->prepare("UPDATE categories SET Navigation = ? WHERE WebsiteID = ? AND Title = ?");
        $query->bind_param('iss', $newMode, $websiteID, $title);
        $result = $query->execute();
        $query->close();
        return $result;
    }

    public function createProduct($name, $description, $originalPrice, $price, $stock, $website_id, $category, $sub_category, $uniqueid)
    {
        $query = $this->conn->prepare("INSERT INTO products(ProductID, Name, Description, OriginalPrice, Price, Stock, WebsiteID, Category, SubCategory) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param('sssssisss', $uniqueid, $name, $description, $originalPrice, $price, $stock, $website_id, $category, $sub_category);

        $result = $query->execute();
        $query->close();
        return $result;
    }

    public function displayAllProducts($websiteID)
    {
        $query = $this->conn->prepare("SELECT * FROM products WHERE WebsiteID = ?");
        $query->bind_param("s", $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getProductInfo($productID)
    {
        $query = $this->conn->prepare("SELECT * FROM products WHERE ProductID = ?");
        $query->bind_param("s", $productID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function updatePage($websiteID, $page, $content)
    {
        $pageContent = $this->getPageContent($websiteID, $page);
        $result = "";

        if($pageContent->num_rows > 0){
            $query = $this->conn->prepare("UPDATE pages SET Content = ? WHERE WebsiteID = ? AND Page = ?");
            $query->bind_param("sss", $content, $websiteID, $page);
            $result = $query->execute();
            $query->close();
        } else {
            $query = $this->conn->prepare("INSERT INTO pages(WebsiteID, Page, Content) VALUES(?, ?, ?)");
            $query->bind_param("sss", $websiteID, $page, $content);
            $result = $query->execute();
            $query->close();
        }
        return $result;
    }

    public function getPageContent($websiteID, $page)
    {
        $query = $this->conn->prepare("SELECT Content FROM pages WHERE WebsiteID = ? AND Page = ?");
        $query->bind_param("ss", $websiteID, $page);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        return $result;
    }


    public function getContent($websiteID, $page){
        $query = $this->conn->prepare("SELECT Content FROM pages WHERE WebsiteID = ? AND Page = ?");
        $query->bind_param("ss", $websiteID, $page);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        return $result;
    }


    /**************** DATA CHART ************/

    public function getMostSold($timeBefore, $websiteID)
    {
        $timestampBefore = strtotime("-$timeBefore day");


        $query = $this->conn->prepare("SELECT OrderID FROM orders WHERE WebsiteID = ? AND Timestamp >= ?");
        $query->bind_param("ss", $websiteID, $timestampBefore);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        $i = 1;

        $orderQuery = "SELECT ProductID, SUM(Quantity) As Quantity FROM orderdetails WHERE OrderID = ";
        while ($orders = $result->fetch_assoc()) {
            $orderQuery .= "'" . $orders["OrderID"] . "'";

            if ($i < $result->num_rows) {
                $orderQuery .= " OR ";
            }
            $i++;
        }

        if ($i > 1) {
            $orderQuery .= " GROUP BY ProductID ORDER BY SUM(Quantity) DESC LIMIT 3";

            $query = $this->conn->prepare($orderQuery);
            $query->execute();
            $result = $query->get_result();
        }

        return $result;
    }

    public function getTotalSales($timeBefore, $websiteID)
    {
        $timestampBefore = strtotime("-$timeBefore day");

        $query = $this->conn->prepare("SELECT Count(OrderID) As AmountOfOrders FROM orders WHERE Timestamp >= ? AND WebsiteID = ?");
        $query->bind_param("ss", $timestampBefore, $websiteID);
        $query->execute();
        $result = $query->get_result();

        $query->close();

        return $result;
    }

    public function getTotalRevenue($timeBefore, $websiteID)
    {
        $timestampBefore = strtotime("-$timeBefore day");

        $query = $this->conn->prepare("SELECT orders.websiteID, orderdetails.OrderID, orderdetails.ProductID, SUM(orderdetails.Quantity) As Quantity,  (products.Price * SUM(orderdetails.Quantity)) As Price
        FROM orderdetails
        INNER JOIN orders ON orderdetails.OrderID = orders.OrderID
        INNER JOIN products ON orderdetails.ProductID = products.ProductID
        WHERE orders.Timestamp >= ? AND orders.WebsiteID = ? GROUP BY ProductID");
        $query->bind_param("ss", $timestampBefore, $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }
}

?>