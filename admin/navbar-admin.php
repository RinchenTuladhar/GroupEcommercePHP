<?php


?>

<body>
<div class="admin-navigation">
    <div class="top-nav">
        <nav class="navbar navbar-expand-md navbar-dark">
            <ul class="navbar-nav mr-auto navbar-left">
                <li class="nav-item">
                    <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <?php echo $_SESSION["FirstName"] . " " . $_SESSION["LastName"]; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../api/logout.php">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="sidebar left">
        <ul>
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <?php if ($_SESSION["hasDomain"]["DomainName"] != null) {
                ?>
                <li><a href="categories.php"><i class="fa fa-list-ul"></i> Categories List</a></li>
                <li><a href="navigation.php"><i class="fa fa-sitemap"></i> Edit Navigation</a></li>
                <li><a href="products.php"><i class="fa fa-shopping-basket"></i> Manage Products</a></li>

            <?php } ?>
        </ul>
    </div>
</div> <!--.navigation-menu-->
</body>>