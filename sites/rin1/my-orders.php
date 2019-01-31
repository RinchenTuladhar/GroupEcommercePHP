<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER['QUERY_STRING'];

$totalPrice = 0;
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Items</title>
</head>

<body>
<div class="home-page orders-main">
    <?php
    include 'navbar.php';
    ?>
    <div class="main">
        <div class="orders-container container">
            <h1>My Orders</h1>
        </div>
    </div>
</div>
