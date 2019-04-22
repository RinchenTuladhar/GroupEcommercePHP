<?php
$url = $_SERVER['REQUEST_URI'];
$splitUrl = array_filter(explode('/', $url));

$domainName = null;

if (isset($_SESSION["hasDomain"]["DomainName"])) {
    $domainName = $_SESSION["hasDomain"]["DomainName"];
}
$_SESSION["WebsiteDetails"] = $db->getWebsiteID($domainName);
?>

<body>
<div class="admin-navigation">
    <div class="top-nav">
        <nav class="navbar navbar-expand-md navbar-dark">
            <ul class="navbar-nav mr-auto navbar-left">
                <li class="nav-item"><a class="navbar-brand" href="dashboard.php">Admin
                        Panel</a></li>
                <div class="responsive-tab">
                    <p class="fa fa-bars" id="open-menu"></p>
                </div>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">
                        <?php echo $_SESSION["FirstName"] . " " . $_SESSION["LastName"]; ?>
                    </a></li>
                <li class="nav-item"><a class="nav-link" href="../api/logout.php">
                        Logout </a></li>
            </ul>
        </nav>
    </div>
    <div class="sidebar left">
        <ul>
            <?php if ($_SESSION["hasDomain"]["DomainName"] != null) { ?>
                <li><a
                            href="../sites/<?php echo $_SESSION["hasDomain"]["DomainName"] ?>/index.php"
                            target="_blank">View My Store</a></li>
            <?php } ?>
            <li><a href="dashboard.php"><p class="fa fa-home"></p>
                    Dashboard</a></li>
            <?php

            if ($_SESSION["hasDomain"]["DomainName"] != null) {
                ?>
                <li><a href="categories.php"><p class="fa fa-list-ul"></p>
                        Categories List</a></li>
                <li><a href="navigation.php"><p class="fa fa-sitemap"></p> Edit
                        Navigation</a></li>
                <li><a href="edit-pages.php"><p class="fa fa-pencil"></p> Edit Pages</a></li>

                <li>
                    <div class="accordion" id="productAccordion">
                        <div class="card">
                            <div class="card-header" id="productOptions">
                                <h5 class="mb-0">
                                    <button type="button" data-toggle="collapse"
                                            data-target="#collapse_product_options" aria-expanded="true"
                                            aria-controls="collapse_product">
                                        <p class="fa fa-shopping-basket"></p> Products
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse_product_options"
                                 class="collapse
                            <?php
                                 if (strpos($splitUrl[3], 'add-product') !== false) {
                                     echo "show";
                                 } else if (strpos($splitUrl[3], 'manage-product') !== false) {
                                     echo "show";
                                 }
                                 ?>"
                                 >
                                <div class="card-body">
                                    <p>
                                        <a href="add-product.php"> Add New Product</a>
                                    </p>
                                    <p>
                                        <a href="manage-product.php"> Manage Product</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                </li>
            <?php } ?>
            <li><a href="reports.php"><p class="fa fa-bar-chart"
                                         aria-hidden="true"></p> Reports</a></li>
            <li><a href="catalogue.php" target="_blank">
                    <p class="fa fa-book" aria-hidden="true"></p></i> Catalogue</a></li>
            <li><a href="debug.php"><p class="fa fa-cogs"></p> Testing</a></li>
        </ul>
    </div>
</div>
<!--.navigation-menu-->
<br>
<script type="text/javascript">
    $('#open-menu').click(function(){
        if($('.admin-navigation .sidebar.left').css('display') === "block"){
            $('.admin-navigation .sidebar.left').css('display', 'none');
        } else {
            $('.admin-navigation .sidebar.left').css('display', 'block');
        }
    });
</script>
</body>
