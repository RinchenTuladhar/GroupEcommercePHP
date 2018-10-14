<?php
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
<title>E-Commerce CMS</title>
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="main">
    <div class="main-image">
        <img src="img/background-clothing-store.jpg">
    </div>
    <h1> Build a site with BuildMyStore.com</h1>
</div>
</body>
</html>