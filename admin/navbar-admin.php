<?php
$url = $_SERVER['REQUEST_URI'];
$splitUrl = array_filter(explode('/', $url));
?>

<body>
	<div class="admin-navigation">
		<div class="top-nav">
			<nav class="navbar navbar-expand-md navbar-dark">
				<ul class="navbar-nav mr-auto navbar-left">
					<li class="nav-item"><a class="navbar-brand" href="dashboard.php">Admin
							Panel</a></li>
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
            <?php if ($_SESSION["hasDomain"]["DomainName"] != null) {?>
            <li><a
					href="../sites/<?php echo $_SESSION["hasDomain"]["DomainName"] ?>/index.php"
					target="_blank">View My Store</a></li>
            <?php } ?>
            <li><a href="dashboard.php"><i class="fa fa-home"></i>
						Dashboard</a></li>
            <?php
            
if ($_SESSION["hasDomain"]["DomainName"] != null) {
                ?>
                <li><a href="categories.php"><i class="fa fa-list-ul"></i>
						Categories List</a></li>
				<li><a href="navigation.php"><i class="fa fa-sitemap"></i> Edit
						Navigation</a></li>
				<li><a href="edit-pages.php"><i class="fa fa-pencil"></i> Edit Pages</a></li>

				<li>
					<div class="accordion" id="productAccordion">
						<div class="card">
							<div class="card-header" id="productOptions">
								<h5 class="mb-0">
									<button type="button" data-toggle="collapse"
										data-target="#collapseProductOptions" aria-expanded="true"
										aria-controls="collapseOne">
										<i class="fa fa-shopping-basket"></i> Products
									</button>
								</h5>
							</div>

							<div id="collapseProductOptions"
								class="collapse
                            <?php
                if (strpos($splitUrl[3], 'add-product') !== false) {
                    echo "show";
                } else if (strpos($splitUrl[3], 'manage-product') !== false) {
                    echo "show";
                }
                ?>"
								aria-labelledby="productOptions" data-parent="#productAccordion">
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
            <li><a href="reports.php"><i class="fa fa-bar-chart"
						aria-hidden="true"></i> Reports</a></li>
				<li><a href="catalogue.php">
				<i class="fa fa-book" aria-hidden="true"></i></i> Catalogue</a></li>

			</ul>
		</div>
	</div>
	<!--.navigation-menu-->
</body>
>
