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
                            <p>£100.00</p>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Net Profit</h3>
                            <p>£100.00</p>
                        </div>
                    </div>
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>New Customer (Last 7 days)</h3>
                            <p>50</p>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Items Sold</h3>
                            <p>600</p>
                        </div>
                    </div>
                    <div class="ct-chart ct-golden-section">

                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <form id="filter-form" method="GET">
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
                            <input type="submit" id="btnSubmit" class="btn btn-success" value="Filter">
                        </div>
                    </div>
                </form>

                <div class="jumbotron">
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Orders Created</h3>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Revenue</h3>
                        </div>
                    </div>
                    <div class="row report-box">
                        <div class="col-md-6 box">
                            <h3>Profit</h3>
                        </div>
                        <div class="col-md-6 box">
                            <h3>Items Purchased</h3>
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
</script>
</body>
</html>