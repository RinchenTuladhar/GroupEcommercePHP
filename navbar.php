<?php 
?>

<body>
<div class="navigation-menu">
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Wedding Guru</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavBar" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNavBar">
                <ul class="navbar-nav mr-auto navbar-left">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage=="index") {echo "active"; } else  {echo "noactive";}?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage=="features") {echo "active"; } else  {echo "noactive";}?>" href="venues.php"> Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage=="about") {echo "active"; } else  {echo "noactive";}?>" href="about.php"> About</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown">
                            <a class="nav-link" href="login.php"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
                </ul>
            </div>
        </div> <!--.container-->
    </nav>
</div> <!--.navigation-menu-->
</body>