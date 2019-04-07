<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../api/db-access.php';

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

?>

<html>
<head>
    <?php include '../api/scripts.php'; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>BuildMyStore: Admin</title>

    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});
    </script>
</head>


<body>
<?php include 'navbar-admin.php'; ?>
<div class="main admin-main admin-reports">
    <div class="col-md-12">
        <!-- Report Navigation -->
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-overview" role="tab"
                   aria-controls="pills-overview" aria-selected="true">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                   aria-controls="pills-home" aria-selected="true">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                   aria-controls="pills-profile" aria-selected="false">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                   aria-controls="pills-contact" aria-selected="false">Categories</a>
            </li>
        </ul>
        <!-- Report Navigation End -->

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="jumbotron">
                    <!-- Overview Report -->
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Net Revenue</h3>
                            <p>£<?php echo $db->getTotalRevenue(-1, $_SESSION["WebsiteID"])->fetch_assoc()["Price"]; ?></p>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Net Profit</h3>
                            <p>£<?php echo $db->getTotalProfit(-1, $_SESSION["WebsiteID"])->fetch_assoc()["Profit"];?></p>
                        </div>
                    </div>
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Total Customers</h3>
                            <p><?php echo $db->getNewCustomerTotal(-1)->fetch_assoc()["Total"]; ?></p>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Total Items Sold</h3>
                            <p><?php echo $db->getAmountOfOrders(-1)->fetch_assoc()["Total"]; ?></p>
                        </div>
                    </div>
                    <!-- Overview Report End -->
                </div>
            </div>
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row report-filter">
                        <div class="col-md-5">
                            <label for="from_date">
                                From:
                            </label>
                            <input type="date" name="from_date" id="from_date" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label for="to_date">
                                To:
                            </label>
                            <input type="date" name="to_date" id="to_date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <br>
                            <input type="button" id="btnSubmit" class="btn btn-success" value="Filter" onclick="ordersReport();">
                        </div>
                    </div>

                <div class="jumbotron">
                    <!-- Orders Report -->
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Orders Created</h3>
                            <p id="report-orders-created">

                            </p>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Revenue</h3>
                            <p id="report-orders-revenue"></p>
                        </div>
                    </div>
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Profit</h3>
                            <p id="report-orders-profit"></p>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Items Purchased</h3>
                            <p id="report-orders-items-purchased"></p>
                        </div>
                    </div>
                    <!-- Orders Report End -->
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row report-filter">
                    <div class="col-md-5">
                        <label for="product_from_date">
                            From:
                        </label>
                        <input type="date" name="product_from_date" id="product_from_date" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label for="product_to_date">
                            To:
                        </label>
                        <input type="date" name="product_to_date" id="product_to_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type="button" id="btnSubmit" class="btn btn-success" value="Filter" onclick="soldItemReport();">
                    </div>
                </div>
                <div class="jumbotron">
                    <!-- Item Report -->
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Most Sold Item</h3>
                            <div id="most_sold_item_chart"></div>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Least Sold Item</h3>
                            <div id="least_sold_item_chart"></div>
                        </div>
                    </div>
                    <!-- Item Report End -->

                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="row report-filter">
                    <div class="col-md-5">
                        <label for="category_from_date">
                            From:
                        </label>
                        <input type="date" name="category_from_date" id="category_from_date" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label for="category_to_date">
                            To:
                        </label>
                        <input type="date" name="category_to_date" id="category_to_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type="button" id="btnSubmit" class="btn btn-success" value="Filter" onclick="categoryReport();">
                    </div>
                </div>
                <div class="jumbotron">
                    <!-- Category Report -->

                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Most Popular Category</h3>
                            <div id="most_popular_category_chart"></div>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Least Popular Category</h3>
                            <div id="least_popular_category_chart"></div>
                        </div>
                    </div>
                    <!-- Category Report End-->

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Sets current date to date input
    document.getElementById('to_date').valueAsDate = new Date();
    document.getElementById('product_to_date').valueAsDate = new Date();
    document.getElementById('category_to_date').valueAsDate = new Date();

    // Function executed upon button click
    function ordersReport(){
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();

        // Gets data by date
        var request = $.ajax({
            url: '../api/orders-report.php',
            type: "GET",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', from: fromDate, to: toDate},
            success: function (data) {
                // Sets Google Chart graphs to each section
                var results = JSON.parse(data);
                for(var i = 0; i < results.length; i++){
                    switch(results[i]["type"]){
                        case "Orders":
                            if(results[i]["result"] == null){
                                $("#report-orders-created").html("0");
                            } else {
                                $("#report-orders-created").html(results[i]["result"]);
                            }

                            break;
                        case "Revenue":
                            if(results[i]["result"] == null){
                                $("#report-orders-revenue").html("£0");
                            } else {
                                $("#report-orders-revenue").html("£" + results[i]["result"]);
                            }
                            break;
                        case "Profit":
                            if(results[i]["result"] == null){
                                $("#report-orders-profit").html("£0");
                            } else {
                                $("#report-orders-profit").html("£" + results[i]["result"]);
                            }
                            break;
                        case "Purchased":
                            if(results[i]["result"] == null){
                                $("#report-orders-items-purchased").html("0");
                            } else {
                                $("#report-orders-items-purchased").html(results[i]["result"]);
                            }
                            break;
                    }
                }
                $.notify("Successfully Updated!", "success");
            }
        });

        return request;
    }

    // Most Sold Item Report
    function soldItemReport(){
        var fromDate = $('#product_from_date').val();
        var toDate = $('#product_to_date').val();


        var temp_title = "Top Items Sold (MAX 5)";
        $.ajax({
            url: '../api/products-most-sold-report.php',
            type: "GET",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', from: fromDate, to: toDate},
            success:function(data)
            {
               itemSoldChart(data, temp_title, 'most_sold_item_chart');
            }
        });

        leastSoldItemReport(fromDate, toDate);
    }

    // Least Sold Item Report
    function leastSoldItemReport(fromDate, toDate){
        var temp_title = "Least Items Sold (MAX 5)";
        $.ajax({
            url: '../api/products-least-sold-report.php',
            type: "GET",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', from: fromDate, to: toDate},
            success:function(data)
            {
                itemSoldChart(data, temp_title, 'least_sold_item_chart');
            }
        });
    }

    // Item Sold Overview
    function itemSoldChart(chart_data, chart_main_title, div){
        var jsonData = JSON.parse(chart_data);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Quantity');
        $.each(jsonData, function(i, jsonData){
            var name = jsonData.name;
            var quantity = parseInt(jsonData.quantity);
            data.addRows([[name, quantity]]);
        });
        var options = {
            title:chart_main_title,
            hAxis: {
                title: "Name"
            },
            vAxis: {
                title: 'Quantity'
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById(div));
        chart.draw(data, options);
    }

    function categoryReport(){
        var fromDate = $('#category_from_date').val();
        var toDate = $('#category_to_date').val();

        var title = "Most Popular Category";
        $.ajax({
            url: '../api/category-most-popular-report.php',
            type: "GET",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', from: fromDate, to: toDate},
            success:function(data)
            {
                itemSoldChart(data, title, 'most_popular_category_chart');
            }
        });

        leastpopularCategoryReport(fromDate, toDate);
    }

    function leastpopularCategoryReport(fromDate, toDate){
        var title = "Least Popular Category"

        $.ajax({
            url: '../api/category-least-popular-report.php',
            type: "GET",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', from: fromDate, to: toDate},
            success:function(data)
            {
                itemSoldChart(data, title, 'least_popular_category_chart');
            }
        });
    }
</script>
</body>
</html>