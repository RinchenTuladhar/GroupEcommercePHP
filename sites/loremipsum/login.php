<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Login</title>
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="main">
    <div class="container">
        <div class="signup-form">

            <h1>Sign in to your store.</h1>
            <form action="api/login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email*:</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Password*:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <input type="submit" class="btn btn-default" value="Sign In">

            </form>
        </div>
    </div>
</div>
</body>
</html>