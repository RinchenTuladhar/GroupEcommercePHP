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

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn();
            data.addColumn();
            data.addRows([
                []
            ]);

            // Set chart options
            var options = {'title':'Top 5 Product Sales',
                'width':400,
                'height':300};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
<?php include 'navbar-admin.php'; ?>

<div class="main admin-main">
    <?php if ($_SESSION["hasDomain"]["Theme"] != null || isset($_SESSION["theme"])) {
    ?>
    <p class="view-my-store float-right"><a href="../sites/<?php echo $_SESSION["hasDomain"]["DomainName"] ?>/index.php" class="btn btn-success" target="_blank">View My Store</a></p>
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
                        <input type="text" name="domain_name" class="form-control" id="inlineFormInputGroup" placeholder="Enter domain name here" required>
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
                        <label><input type="radio"  id="theme-2" name="theme" value="theme-2"> Theme 2</label>
                    </div>
                <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">

                <input type="submit" class="btn btn-success float-right" value="Submit">
            </div>
        </form>
    </div>
    <?php } ?>

    <div id="chart_div"></div>
</div>
</body>
</html>