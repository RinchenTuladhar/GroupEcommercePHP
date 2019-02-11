<?php
include 'api/db-access.php';

$url = $_SERVER['REQUEST_URI'];
$splitUrl = array_filter(explode('/', $url));

$siteName;

if ($splitUrl[3] === "sites") {
    $siteName = $splitUrl[4];
} else {
    $siteName = $splitUrl[3];
}

$_SESSION["SiteName"] = $siteName;

$_SESSION["WebsiteDetails"] = $db->getWebsiteID($siteName);

?>

<body>
<div class="navigation-menu">
    <nav class="navbar navbar-expand-md navbar-dark">
        <a class="navbar-brand" href="#"><?php echo $siteName; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavBar"
                aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNavBar">
            <ul class="navbar-nav mr-auto navbar-left">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php
                $listOfNavigation = $db->getCategoryNavigation($siteName);
                while ($row = $listOfNavigation->fetch_assoc()) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="products.php?<?php echo $row['Title']; ?>"><?php echo $row["Title"] ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="basket.php"><i class="fa fa-shopping-cart"></i>
                        £<span id="basket-price"><?php
                            if (isset($_SESSION["TotalPrice"])) {
                                echo number_format((float)$_SESSION["TotalPrice"], 2, '.', '');
                            } else {
                                echo "0.00";
                            } ?></span></a>
                </li>
                <?php if (!isset($_SESSION["store_loggedin"]) || $_SESSION["store_loggedin"] == null) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Your Account</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="my-orders.php">Orders</a>
                            <a class="dropdown-item" href="api/logout.php">Sign out</a>
                        </div>
                    </li>

                <?php } ?>
            </ul>
        </div>
    </nav>
</div> <!--.navigation-menu-->
</body>