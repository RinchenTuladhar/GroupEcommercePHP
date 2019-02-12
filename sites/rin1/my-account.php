<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER['QUERY_STRING'];

?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Items</title>
</head>

<body>
<div class="home-page account-main">
    <?php
    include 'navbar.php';



    ?>
    <div class="main">
        <div class="container">
            <h1>My Details</h1>
            <p>Feel free to edit any of your details below so your account is totally up to date.</p>

            <div class="row">
                <div class="col-md-6">
                    <form action="api/edit-account.php" method="POST">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $_SESSION['customer']['FirstName'];?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $_SESSION['customer']['LastName'];?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['customer']['email'];?>" required>
                        </div>
                        <input type="hidden" value="<?php echo $_SESSION["WebsiteDetails"]["WebsiteID"] ?>"
                               name="website-id">
                        <input type="submit" class="btn btn-default" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
