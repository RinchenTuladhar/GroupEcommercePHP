<?php

require_once 'db/functions.php';
$db = new Functions();

    $websiteID = $_POST["websiteID"];
    $amountOfUsers = $_POST["amount_of_names"];
    $password = $_POST["password"];

    $firstNames = file("../admin/debug/first-names.txt");
    $lastNames = file("../admin/debug/last-names.txt");

    $sqlStatement = "";

    $listOfNames = [];

    for($i = 0; $i < $amountOfUsers; $i++){
        $values = "";

        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];

        $email = ($firstName . $lastName . "@ecommerce.com");
        $email = strtolower(preg_replace('/\s/', '', $email));

        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        $time = time();

        if($i == ($amountOfUsers -1)){
            $sqlStatement .= "('$email', '$firstName', '$lastName', '$encryptedPassword', '$websiteID', 0, $time); ";
        } else {
            $sqlStatement .= "('$email', '$firstName', '$lastName', '$encryptedPassword', '$websiteID', 0, $time), ";
        }
    }

    $db->debug($sqlStatement);

    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>