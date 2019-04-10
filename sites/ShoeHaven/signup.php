<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Signup</title>
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="main">
    <div class="container">
        <div class="signup-form">

            <h1>Sign up to <?php echo $_SESSION["SiteName"] ?></h1>
            <form action="api/register.php" method="POST">
                <div class="form-group">
                    <label for="first_name">First Name*:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name*:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address*:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password*:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <input type="hidden" value="<?php echo $_SESSION["WebsiteDetails"]["WebsiteID"];?>" name="website-id">
                <input type="submit" class="btn btn-default" value="Register">
            </form>
        </div>
    </div>
</div>
</body>
</html>