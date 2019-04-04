<?php
include '../api/db-access.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

?>

<html>
<head>
    <?php include '../api/scripts.php'; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>BuildMyStore: Admin</title>
</head>

<body>
<?php include 'navbar-admin.php'; ?>
<div class="admin admin-main">
    <h1>DEBUG MODE</h1>
    <p>This page allows you to generate a random amount of data to your website depending on how many uers you
        select.</p>
    <p>Below please enter the amount of users you would like to be added to the database.</p>

    <hr/>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="jumbotron col-md-6">
            <form action="../api/debug.php" method="POST">
                <label for="amount_of_names">Amount of Users:</label>
                <input type="number" class="form-control" name="amount_of_names" required>
                <label for="password_for_users">Set User Password:</label>
                <input type="password" class="form-control" name="password" required>
                <input type="hidden" value="<?php echo $_SESSION['WebsiteID']?>" name="websiteID">
                <br>
                <input type="submit" class="btn btn-danger float-right" value="Create Users">
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

</body>
</html>