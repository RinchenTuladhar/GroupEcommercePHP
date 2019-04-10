<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER['QUERY_STRING'];

?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Home</title>
</head>

<body>
	<div class="home-page">
    <?php include 'navbar.php'; ?>
    <div class="main">
			<div class="product-list container">
			<?php
                                
			$parentCategory = $db->getParentCategory($_SESSION["WebsiteID"], $query);
			$parentCategory = $parentCategory->fetch_assoc()["Category"];
			
			$content = $db->getContent($_SESSION["WebsiteDetails"]["WebsiteID"], $parentCategory, $query);
                                                
                echo (htmlspecialchars_decode($content->fetch_assoc()["Content"]));
            ?>
                        
            <h1 class="product-title"><?php echo $query; ?></h1>
				<div class="row">
                <?php
                $products = $db->getCategoryProducts($_SESSION["WebsiteDetails"]["WebsiteID"], $query);
                
                while ($row = $products->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
						<div class="product-wrapper">
							<div class="product-image">
								<img
									src="<?php echo "img/items/" . $row["ProductID"] . ".jpg";?>">
							</div>
							<div class="product-title">
								<p>
									<a href="item.php?<?php echo $row["ProductID"]; ?>"><?php echo $row["Name"]?></a>
								</p>
							</div>
							<div class="product-price">
								<p>£<?php echo $row["Price"]; ?></p>
							</div>
						</div>
					</div>
                    <?php
                }
                ?>
            </div>
			</div>
		</div>
	</div>
</body>
</html>