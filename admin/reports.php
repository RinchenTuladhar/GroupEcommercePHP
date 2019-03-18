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
</head>


<body>
<?php include 'navbar-admin.php'; ?>
<div class="main admin-main admin-reports">
    <div class="col-md-12">
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
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="jumbotron">
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
                </div>
            </div>
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <form>
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
                </form>

                <div class="jumbotron">
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
                    <div class="ct-chart ct-golden-section">

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="jumbotron">
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Most Sold Item</h3>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Least Sold Item</h3>
                        </div>
                    </div>

                    <div class="ct-chart ct-golden-section">

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="jumbotron">
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Most Popular Category</h3>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Least Popular Category</h3>
                        </div>
                    </div>

                    <div class="ct-chart ct-golden-section">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('to_date').valueAsDate = new Date();

    function ordersReport(){
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();

        var request = $.ajax({
            url: '../api/orders-report.php',
            type: "GET",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', from: fromDate, to: toDate},
            success: function (data) {
                var results = JSON.parse(data);
                for(var i = 0; i < results.length; i++){
                    switch(results[i]["type"]){
                        case "Orders":
                            $("#report-orders-created").html(results[i]["result"]);
                            break;
                        case "Revenue":
                            $("#report-orders-revenue").html(results[i]["result"]);
                            break;
                        case "Profit":
                            $("#report-orders-profit").html(results[i]["result"]);
                            break;
                        case "Purchased":
                            $("#report-orders-items-purchased").html(results[i]["result"]);
                            break;
                    }
                }
                $.notify("Successfully Updated!", "success");
            }
        });

        return request;
    }
</script>
</body>
</html>