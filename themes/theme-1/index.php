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
        <div class="container">
            <div class="col-md-12">
                <?php

                $content = $db->getContent($_SESSION["WebsiteDetails"]["WebsiteID"], "index");

                echo(htmlspecialchars_decode($content->fetch_assoc()["Content"]));
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>