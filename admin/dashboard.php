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
        <div class="row indicator">
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
        <div class="dashboard-week-stats row">
            <div class="col-md-12 row">
                <div class="col-md-4 stat-box">
                    <h5>Orders Made</h5>
                    <span id="stat-week-sales"><p>
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
                    <span id="stat-week-sales"><p>
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
                    <span id="stat-week-sales">
                    <?php
                    $i = 0;
                    while ($row = $mostSold7->fetch_assoc()) {
                        if ($i == 0) {
                            ?>
                            <p><?php echo ($db->getProductInfo($row["ProductID"])->fetch_assoc())["Name"]; ?></p>
                        <?php }
                        $i++;
                    } ?>
                </span>
                </div>
            </div>
            <hr/>
        </div>
        <h4>Top 3 Products in the last 30 days</h4>
        <?php
        $mostSold30 = $db->getMostSold(30, $_SESSION["WebsiteID"]);

        ?>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="ct-chart ct-golden-section">
                    <script type="text/javascript">
                        var data = {
                            labels: [
                                <?php

                                while ($row = $mostSold30->fetch_assoc()) {
                                    echo "'" . $db->getProductInfo($row["ProductID"])->fetch_assoc()["Name"] . "' , ";
                                }

                                mysqli_data_seek($mostSold30, 0);
                                ?>
                            ],
                            series: [
                                <?php
                                while ($row = $mostSold30->fetch_assoc()) {
                                    echo($row["Quantity"] . ", ");
                                }
                                ?>
                            ],
                        };

                        var sum = function (a, b) {
                            return a + b
                        };


                        var options = {
                            labelInterpolationFnc: function (value) {
                                return Math.round(value / data.series.reduce(sum) * 100) + '%';
                            }
                        };

                        var responsiveOptions = [
                            ['screen and (min-width: 640px)', {
                                chartPadding: 30,
                                labelOffset: 100,
                                labelDirection: 'explode',
                                labelInterpolationFnc: function (value) {
                                    return value;
                                }
                            }],
                            ['screen and (min-width: 1024px)', {
                                labelOffset: 80,
                                chartPadding: 20
                            }]
                        ];

                        new Chartist.Pie('.ct-chart', data, options, responsiveOptions);
                    </script>
                    <?php
                    while ($test = $mostSold30->fetch_assoc()) {
                        echo($test["Quantity"] . ", ");
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
</body>
</html>