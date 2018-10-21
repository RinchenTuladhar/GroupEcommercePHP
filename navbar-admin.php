<?php


?>

<body>
<div class="admin-navigation">
    <div class="top-nav">
        <nav class="navbar navbar-expand-md navbar-dark">
            <ul class="navbar-nav mr-auto navbar-left">
                <li class="nav-item">
                    <a class="navbar-brand" href="admin.php">Admin Panel</a>
                </li>
            </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">
                            <?php echo $_SESSION["FirstName"] . " " . $_SESSION["LastName"]; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="api/logout.php">
                            Logout
                        </a>
                    </li>
                </ul>
        </nav>
    </div>
    <div class="sidebar left">
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="#">Create Website</a></li>
            <li><a href="#">Create Categories</a></li>
            <li><a href="#">Add Products</a></li>
        </ul>
    </div>
</div> <!--.navigation-menu-->
</body>>