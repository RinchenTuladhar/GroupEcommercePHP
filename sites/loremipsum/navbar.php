<?php
include 'api/db-access.php';

$url = $_SERVER['REQUEST_URI'];
$splitUrl = array_filter(explode('/', $url));

$siteName = $splitUrl[3];
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
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION["loggedin"])) {
                    ?>
                    <?php if ($_SESSION['loggedin'] == null) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Sign Up</a>
                        </li>
                        <?php
                    } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="basket.php"><i class="fa fa-shopping-cart"></i> £0.00</a>
                        </li>
                    <?php } ?>
                    <?php
                } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav mr-auto navbar-left">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php
                $categoryList = $db->getCategoryNavigation($_SESSION["WebsiteID"]);
                var_dump($categoryList );
                if ($categoryList->num_rows > 0) {
                    while ($row = $categoryList->fetch_assoc()) {
                        if ($row["Navigation"] == 1) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="products.php">Shirts</a>
                            </li>
                        <?php }
                    }
                } ?>
            </ul>
        </div>
    </nav>
</div> <!--.navigation-menu-->
</body>