<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Home</title>
</head>

<body>
<div class="home-page">
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="main-image">
            <img src="img/background-clothing-store.jpg">
            <h1> Build a beautiful marketplace for your needs.</h1>
        </div>
    </div>
</div>
</body>
</html>