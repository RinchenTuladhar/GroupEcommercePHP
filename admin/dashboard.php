<?php
include '../api/db-access.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

?>

<html lang="en">
<head>
    <?php include '../api/scripts.php'; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>BuildMyStore: Admin</title>
</head>

<body>
<?php include 'navbar-admin.php'; ?>

<div class="main admin-main">
    <?php if ($_SESSION["hasDomain"]["Theme"] != null || isset($_SESSION["theme"])) {
        ?>
        <p class="view-my-store float-right"><a
                    href="../sites/<?php echo $_SESSION["hasDomain"]["DomainName"] ?>/index.php" class="btn btn-success"
                    target="_blank">View My Store</a></p>
    <?php } ?>
    <h1> Welcome <?php echo $_SESSION["FirstName"]; ?></h1>
    <?php if ($_SESSION["hasDomain"]["DomainName"] == null) {
        ?>
        <div class="indicator">
            <i class="fa fa-lock"></i> <br>
            <form action="../api/domainname.php" method="POST">
                <h3>Step 1: Please enter a domain name to get started.</h3> <br>
                <div class="col-auto">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">www.</div>
                        </div>
                        <input type="text" name="domain_name" class="form-control" id="inlineFormInputGroup"
                               placeholder="Enter domain name here" required>
                    </div>

                    <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">
                    <input type="submit" class="btn btn-success float-right" value="Submit">
                </div>
            </form>
        </div>
        <?php
    } else {

        ?>
    <?php } ?>
    <br>

    <?php if ($_SESSION["hasDomain"]["Theme"] == null) {
        ?>
        <div class="row indicator">
            <i class="fa fa-lock"></i> <br>
            <form action="../api/select-theme.php" method="POST">
                <h3>Step 2: Select your theme.</h3> <br>
                <div class="col-auto">
                    <div class="radio">
                        <label><input type="radio" id="theme-1" name="theme" value="theme-1"> Theme 1</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" id="theme-2" name="theme" value="theme-2"> Theme 2</label>
                    </div>
                    <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">

                    <input type="submit" class="btn btn-success float-right" value="Submit">
                </div>
            </form>
        </div>
    <?php }

    // Dashboard Statistics
    $mostSold7 = $db->getMostSold(7, $_SESSION["WebsiteID"]);
    $amountOfSales = ($db->getTotalSales(7, $_SESSION["WebsiteID"]));
    $revenue = $db->getTotalRevenue(7, $_SESSION["WebsiteID"]);

    ?>

    <div class="dashboard-statistics">
        <h2 class="text-center">This Week's Stats</h2>
        <hr/>
        <div class="dashboard-week-stats">
            <!-- DASHBOARD STATISTICS -->
            <div class="row col-md-12">
                <div class="col-md-4 stat-box">
                    <h5>Orders Made</h5>
                    <span class="stat-week-sales"><p>
                        <?php
                        $i = 0;
                        while ($row = $amountOfSales->fetch_assoc()){
                        if ($i == 0){
                        ?>
                    <p>
                        <?php echo $row["AmountOfOrders"]; ?></p>
                        <?php }
                        $i++;
                        } ?>
                        </p></span>
                </div>
                <div class="col-md-4 stat-box">
                    <h5>Revenue</h5>
                    <span class="stat-week-sales"><p>
                        £<?php
                            $total = 0;
                            while ($row = $revenue->fetch_assoc()) {
                                $total = $total + $row["Price"];
                            }

                            echo $total;
                            ?>
                    </p></span>
                </div>
                <div class="col-md-4 stat-box">
                    <h5>Most Popular Item</h5>
                    <span class="stat-week-sales">
                    <?php
                    $i = 0;
                    if($mostSold7->num_rows > 0){
                        while ($row = $mostSold7->fetch_assoc()) {
                            if ($i == 0) {
                                ?>
                                <p><?php echo ($db->getProductInfo($row["ProductID"])->fetch_assoc())["Name"]; ?></p>
                            <?php }
                            $i++;
                        }
                    } else {
                        echo "<p>No Items Sold</p>";
                    }
                    ?>
                </span>
                </div>
            </div>
            <!-- END OF DASHBOARD STATISTICS -->
            <hr/>
        </div>
    </div>
</div>
</body>
</html>