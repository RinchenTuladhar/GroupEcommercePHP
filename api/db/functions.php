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

        $query = $this->conn->prepare("INSERT INTO Users(Email, FirstName, LastName, EncryptedPassword, WebsiteID, Admin) VALUES(?, ?, ?, ?, ?, 1)");
        $query->bind_param("sssss", $email, $firstName, $lastName,$encryptedPassword, $websiteID);
        $result = $query->execute();
        $query->close();

        return $result;
    }

    public function checkPassword($email, $password){
        $query = $this->conn->prepare("SELECT * FROM Users WHERE Email = ?");
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
}

?>