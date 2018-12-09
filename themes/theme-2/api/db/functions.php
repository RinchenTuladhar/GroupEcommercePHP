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
        $query->bind_param("sssss", $email, $firstName, $lastName,$encryptedPassword, $websiteID);
        $result = $query->execute();
        $query->close();

        return $result;
    }

    public function checkPassword($email, $password){
        $query = $this->conn->prepare("SELECT * FROM users WHERE Email = ?");
        $query->bind_param('s', $email);
        $query->execute();

        $user = $query->get_result()->fetch_assoc();

        $query->close();

        var_dump(password_verify($password, $user["EncryptedPassword"]));
        if(password_verify($password, $user["EncryptedPassword"])) {
            return $user;
        } else {
            return null;
        }
    }

    public function hasDomainName($websiteID){ // Checks to see if user has named their domain
        $query = $this->conn->prepare("SELECT * FROM websites WHERE WebsiteID = ?");
        $query->bind_param('s', $websiteID);
        $query->execute();

        $hasDomain = $query->get_result()->fetch_assoc();

        $query->close();

        return $hasDomain;
    }

    public function createDomainName($domain, $websiteID){
        $query = $this->conn->prepare("SELECT * FROM websites WHERE DomainName = ?");
        $query->bind_param('s', $domain);
        $query->execute();

        $oldDomain = $query->get_result()->fetch_assoc();

        $query->close();

        if($oldDomain == null){
            $query = $this->conn->prepare("UPDATE websites SET DomainName = ? WHERE WebsiteID = ?");
            $query->bind_param('ss', $domain, $websiteID);
            $query->execute();
            $query->close();
        }

        return $query;
    }
}

?>