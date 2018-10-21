<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['loggedin'] == null) {
    header("Location:../login.php");
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Admin</title>
</head>

<body>
<?php include 'navbar-admin.php'; ?>

<div class="main admin-main">
    <h1> Welcome <?php echo $_SESSION["FirstName"]; ?></h1>
    <?php if ($_SESSION["hasDomain"] == null) {
        ?>
        <div class="row indicator">
            <i class="fa fa-lock"></i> <br>
            <form action="api/domainname.php" method="POST">
                <h3>Please enter a domain name for your website before continuing.</h3> <br>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">www.</div>
                        </div>
                        <input type="text" name="domain_name" class="form-control" id="inlineFormInputGroup" placeholder="Enter domain name here" required>
                    </div>

                    <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">
                    <input type="submit" class="btn btn-success float-right" value="Submit">
                </div>
            </form>
        </div>
        <?php
    } ?>

</div>
</body>
</html>