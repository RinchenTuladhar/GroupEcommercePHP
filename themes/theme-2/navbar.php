<?php
include 'api/db-access.php';

$url = $_SERVER['REQUEST_URI'];
$splitUrl = array_filter(explode('/', $url));

$siteName;

if($splitUrl[3] === "sites"){
    $siteName = $splitUrl[4];
}  else {
    $siteName = $splitUrl[3];
}

$_SESSION["WebsiteDetails"] = $db->getWebsiteID($siteName);

?>
<body>

<div id="top-bar">
    <a class="navbar-brand" href="index.php"><?php echo $siteName; ?></a>
    <p class="float-right">Signup / Login</p>
</div>

<div class="navigation-menu">
    <nav class="navbar navbar-expand-md navbar-light">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavBar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNavBar">
            <ul class="navbar-nav mr-auto mx-md-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php
                $listOfNavigation = $db->getCategoryNavigation($siteName);
                while($row = $listOfNavigation->fetch_assoc()){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php?<?php echo $row['Title'];?>"><?php echo $row["Title"]?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION["loggedin"])){
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
                }else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div> <!--.navigation-menu-->
</body>