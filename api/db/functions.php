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

    public function debug($sql){
        $statement = "INSERT INTO users (Email, FirstName, LastName, EncryptedPassword, WebsiteID, Admin, Timestamp) VALUES";
        $statement .= $sql;

        echo $statement;
        $query = $this->conn->prepare($statement);
        $result = $query->execute();
        $query->close();
        return $result;
    }

    public function createAdmin($firstName, $lastName, $email, $password)
    {
        $timestamp = time();
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        $websiteID = md5(uniqid($email, true));

        $query = $this->conn->prepare("INSERT INTO websites(WebsiteID, OwnerEmail, DomainName) VALUES(?, ?, null)");
        $query->bind_param("ss", $websiteID, $email);
        $query->execute();
        $query->close();

        $query = $this->conn->prepare("INSERT INTO users(Email, FirstName, LastName, EncryptedPassword, WebsiteID, Admin, Timestamp) VALUES(?, ?, ?, ?, ?, 1, ?)");
        $query->bind_param("ssssss", $email, $firstName, $lastName, $encryptedPassword, $websiteID, $timestamp);
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
    
    public function getWebsiteID($websiteName)
    {
        $query = $this->conn->prepare("SELECT * FROM websites WHERE DomainName = ?");
        $query->bind_param("s", $websiteName);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        
        $query->close();
        return $result;
        
    }

    public function createCategory($category, $websiteID)
    {
        $str_arr = explode(",", $category);
        $sqlStatement = "INSERT INTO categories(Title, WebsiteID, Navigation, NavOrder) VALUES ";

        for ($i = 0; $i < sizeof($str_arr); $i++) {
            if ($i == (sizeof($str_arr) - 1)) {
                $sqlStatement .= "('" . str_replace(' ', '', $str_arr[$i]) . "' , '" . $websiteID . "', 0, $i);";
            } else {
                $sqlStatement .= "('" . str_replace(' ', '', $str_arr[$i]) . "' , '" . $websiteID . "', 0, $i);";
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

    // Checks how many subcategories are linked with a category
    public function checkCategorySubs($category, $websiteID)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) As Total FROM subcategory WHERE Category = ? AND WebsiteID = ?");
        $query->bind_param("ss", $category, $websiteID);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();

        return $result;
    }

    // Checks how many items linked to a subcategory
    public function checkSubCategoryItems($category, $subCategory, $websiteID)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) As Total FROM products WHERE Category = ? AND SubCategory = ? AND WebsiteID = ?");
        $query->bind_param("sss", $category, $subCategory, $websiteID);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();

        return $result;
    }

    public function deleteCategory($category, $websiteID)
    {
        $result = false;
        // If category has no sub categories
        if ($this->checkCategorySubs($category, $websiteID)["Total"] === 0) {
            echo "DELETE FROM category WHERE Title = $category AND WebsiteID = $websiteID";
            $query = $this->conn->prepare("DELETE FROM categories WHERE Title = ? AND WebsiteID = ?");
            $query->bind_param("ss", $category, $websiteID);
            $query->execute();
            $query->close();

            $result = true;
        }

        return $result;
    }

    public function deleteSubCategory($category, $subCategory, $websiteID)
    {
        $result = false;

        if ($this->checkSubCategoryItems($category, $subCategory, $websiteID)["Total"] === 0) {
            $query = $this->conn->prepare("DELETE FROM subcategory WHERE Category = ? AND SubCategory = ? AND WebsiteID = ?");
            $query->bind_param("sss", $category, $subCategory, $websiteID);
            $query->execute();
            $query->close();

            $result = true;
        }

        return $result;
    }

    public function getCategories($websiteID)
    {
        $query = $this->conn->query("SELECT * FROM categories WHERE WebsiteID = '$websiteID' ORDER BY NavOrder ASC");
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

    public function setNavigationOrder($websiteID, $navigationList)
    {
        $query = "";

        for ($i = 0; $i < sizeof($navigationList); $i++) {
            $query = $this->conn->prepare("UPDATE categories SET NavOrder = ? WHERE Title = ? AND WebsiteID = ?");
            $query->bind_param("iss", $i, $navigationList[$i], $websiteID);
            $query->execute();
        }
        $result = $query;
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
    
    public function getProductBySubCategory($websiteID, $category, $subCategory){
        $query = $this->conn->prepare("SELECT * FROM products WHERE WebsiteID = ? AND Category = ? AND SubCategory = ?");
        $query->bind_param("sss", $websiteID, $category, $subCategory);
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

    public function updateProductInfo($productID, $name, $price, $stock){
        $query = $this->conn->prepare("UPDATE products SET Name = ?, Price = ?, Stock = ? WHERE ProductID = ?");
        $query->bind_param("ssis", $name, $price, $stock, $productID);
        $query->execute();
        $query->close();

        return $query;
    }

    public function updatePage($websiteID, $category, $subCategory, $content)
    {
        $pageContent = $this->getPageContent($websiteID, $category, $subCategory);
        $result = "";
        
        if ($pageContent->num_rows > 0) {
            $query = $this->conn->prepare("UPDATE pages SET Content = ? WHERE WebsiteID = ? AND Category = ? AND SubCategory = ?");
            $query->bind_param("ssss", $content, $websiteID, $category, $subCategory);
            $result = $query->execute();
            $query->close();
        } else {
            $query = $this->conn->prepare("INSERT INTO pages(WebsiteID, Category, SubCategory, Content) VALUES(?, ?, ?, ?)");
            $query->bind_param("ssss", $websiteID, $category, $subCategory, $content);
            $result = $query->execute();
            $query->close();
        }
        
        return $result;
    }

    public function getPageContent($websiteID, $category, $subCategory)
    {
        $query = $this->conn->prepare("SELECT Content FROM pages WHERE WebsiteID = ? AND Category = ? AND SubCategory = ?");
        $query->bind_param("sss", $websiteID, $category, $subCategory);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        return $result;
    }


    public function getContent($websiteID, $category, $subCategory)
    {
        $query = $this->conn->prepare("SELECT Content FROM pages WHERE WebsiteID = ? AND Category = ? AND SubCategory = ?");
        $query->bind_param("sss", $websiteID, $category, $subCategory);
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

    public function getMostSoldByDate($from, $to, $websiteID)
    {
        $query = $this->conn->prepare("SELECT OrderID FROM orders WHERE WebsiteID = ? AND Timestamp >= ? AND Timestamp <= ?");
        $query->bind_param("sss", $websiteID, $from, $to);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        $i = 1;

        $orderQuery = "SELECT products.Name, orderdetails.ProductID, SUM(orderdetails.Quantity) As Quantity FROM orderdetails INNER JOIN products ON products.ProductID = orderdetails.ProductID WHERE orderdetails.OrderID = ";
        while ($orders = $result->fetch_assoc()) {
            $orderQuery .= "'" . $orders["OrderID"] . "'";

            if ($i < $result->num_rows) {
                $orderQuery .= " OR ";
            }
            $i++;
        }

        if ($i > 1) {
            $orderQuery .= "GROUP BY orderdetails.ProductID ORDER BY SUM(Quantity) DESC LIMIT 3";

            $query = $this->conn->prepare($orderQuery);
            $query->execute();
            $result = $query->get_result();
        }

        return $result;
    }

    public function getLeastSoldByDate($from, $to, $websiteID)
    {
        $query = $this->conn->prepare("SELECT OrderID FROM orders WHERE WebsiteID = ? AND Timestamp >= ? AND Timestamp <= ?");
        $query->bind_param("sss", $websiteID, $from, $to);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        $i = 1;

        $orderQuery = "SELECT products.Name, orderdetails.ProductID, SUM(orderdetails.Quantity) As Quantity FROM orderdetails INNER JOIN products ON products.ProductID = orderdetails.ProductID WHERE orderdetails.OrderID = ";
        while ($orders = $result->fetch_assoc()) {
            $orderQuery .= "'" . $orders["OrderID"] . "'";

            if ($i < $result->num_rows) {
                $orderQuery .= " OR ";
            }
            $i++;
        }

        if ($i > 1) {
            $orderQuery .= "GROUP BY orderdetails.ProductID ORDER BY SUM(Quantity) ASC LIMIT 3";

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

        if ($timeBefore < 0) {
            $timestampBefore = 0;
        }
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

    public function getTotalProfit($timeBefore, $websiteID)
    {
        $timestampBefore = strtotime("-$timeBefore day");

        if ($timeBefore < 0) {
            $timestampBefore = 0;
        }

        $query = $this->conn->prepare("SELECT orders.websiteID, orderdetails.OrderID, orderdetails.ProductID, SUM(orderdetails.Quantity) As Quantity,  SUM(products.Price - products.OriginalPrice) As Profit
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

    public function getNewCustomerTotal($timeBefore)
    {
        $timestampBefore = strtotime("-$timeBefore day");

        if ($timeBefore < 0) {
            $timestampBefore = 0;
        }

        $query = $this->conn->prepare("SELECT COUNT(*) As Total FROM users WHERE Timestamp >= ?");
        $query->bind_param("s", $timestampBefore);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getAmountOfOrders($timeBefore)
    {
        $timestampBefore = strtotime("-$timeBefore day");

        if ($timeBefore < 0) {
            $timestampBefore = 0;
        }

        $query = $this->conn->prepare("SELECT SUM(orderdetails.Quantity) As Total FROM commerce.orderdetails 
INNER JOIN orders ON orderdetails.OrderID = orders.OrderID
WHERE orders.Timestamp >= ?;");
        $query->bind_param("s", $timestampBefore);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    /* REPORTS PAGE */
    public function getRevenueFromDate($from, $to, $websiteID)
    {
        $query = $this->conn->prepare("SELECT orders.websiteID, orderdetails.OrderID, orderdetails.ProductID, SUM(orderdetails.Quantity) As Quantity,  (products.Price * SUM(orderdetails.Quantity)) As Price
        FROM orderdetails
        INNER JOIN orders ON orderdetails.OrderID = orders.OrderID
        INNER JOIN products ON orderdetails.ProductID = products.ProductID
        WHERE orders.Timestamp >= ? AND orders.Timestamp <= ? AND orders.WebsiteID = ? GROUP BY ProductID");
        $query->bind_param("sss", $from, $to, $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getAmountOfOrdersByDate($from, $to, $websiteID)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) As Total FROM commerce.orderdetails 
INNER JOIN orders ON orderdetails.OrderID = orders.OrderID
WHERE orders.Timestamp >= ? AND orders.Timestamp <= ? AND orders.WebsiteID = ?;");
        $query->bind_param("sss", $from, $to, $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getTotalProfitByDate($from, $to, $websiteID)
    {

        $query = $this->conn->prepare("SELECT orders.websiteID, orderdetails.OrderID, orderdetails.ProductID, SUM(orderdetails.Quantity) As Quantity,  SUM(products.Price - products.OriginalPrice) As Profit
        FROM orderdetails
        INNER JOIN orders ON orderdetails.OrderID = orders.OrderID
        INNER JOIN products ON orderdetails.ProductID = products.ProductID
        WHERE orders.Timestamp >= ? AND orders.Timestamp <= ? AND orders.WebsiteID = ? GROUP BY ProductID");
        $query->bind_param("sss", $from, $to, $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getAmountOfItemsPurchasedByDate($from, $to, $websiteID)
    {
        $query = $this->conn->prepare("SELECT SUM(orderdetails.Quantity) As Total FROM commerce.orderdetails 
INNER JOIN orders ON orderdetails.OrderID = orders.OrderID
WHERE orders.Timestamp >= ? AND orders.Timestamp <= ? AND orders.WebsiteID = ?;");
        $query->bind_param("sss", $from, $to, $websiteID);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getMostPopularCategoryByDate($from, $to, $websiteID){
        $query = $this->conn->prepare("SELECT SUM(orderdetails.Quantity) As Quantity, products.Category FROM products 
INNER JOIN orderdetails ON orderdetails.ProductID = products.ProductID
INNER JOIN orders ON orders.OrderID = orderdetails.OrderID
WHERE orders.websiteID = ? AND orders.Timestamp >= ? AND orders.Timestamp <= ?
GROUP BY products.Category ORDER BY SUM(orderdetails.Quantity) DESC;");
        $query->bind_param("sss", $websiteID, $from, $to);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

    public function getLeastPopularCategoryByDate($from, $to, $websiteID){
        $query = $this->conn->prepare("SELECT SUM(orderdetails.Quantity) As Quantity, products.Category FROM products 
INNER JOIN orderdetails ON orderdetails.ProductID = products.ProductID
INNER JOIN orders ON orders.OrderID = orderdetails.OrderID
WHERE orders.websiteID = ? AND orders.Timestamp >= ? AND orders.Timestamp <= ?
GROUP BY products.Category ORDER BY SUM(orderdetails.Quantity) ASC;");
        $query->bind_param("sss", $websiteID, $from, $to);
        $query->execute();
        $result = $query->get_result();
        $query->close();

        return $result;
    }

}

?>