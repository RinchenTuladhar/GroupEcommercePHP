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
    <?php } ?>

    <h4>Top 3 Products in the last 30 days</h4>
    <?php
    $mostSold = $db->getMostSold(30, $_SESSION["WebsiteID"]);

    ?>
    <div class="col-md-4">
        <div class="ct-chart ct-golden-section">
            <script type="text/javascript">
                var data = {
                    labels: [
                        <?php

                        while ($row = $mostSold->fetch_assoc()) {
                            echo "'" . $db->getProductInfo($row["ProductID"])->fetch_assoc()["Name"] . "' , ";
                        }
                        
                        mysqli_data_seek($mostSold,0);
                        ?>
                    ],
                    series: [
                        <?php
                        while ($row = $mostSold->fetch_assoc()) {
                            echo($row["Quantity"] . ", ");
                        }
                        ?>
                    ],
                };

                var sum = function(a, b) { return a + b };


                var options = {
                    labelInterpolationFnc: function(value) {
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
            while ($test = $mostSold->fetch_assoc()) {
                echo($test["Quantity"] . ", ");
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>