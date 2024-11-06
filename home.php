<?php 
	require_once('php/conn.php');

	// 8 SP ngẫu nhiên
	// Sử dụng Prepared Statements để tránh SQL injection
    $stmt = $conn->prepare("
		SELECT p.*, c.category_name 
		FROM products p 
		JOIN categories c ON p.category_id = c.category_id 
		ORDER BY RAND() 
		LIMIT 8
	");
    $stmt->execute();
    $result = $stmt->get_result();

	$products = []; // Khởi tạo mảng để lưu trữ sản phẩm

	while ($row = $result->fetch_assoc()) {
		$products[] = $row; // Thêm từng dòng vào mảng
	}









?>


<!DOCTYPE html>
<html lang="en">
	<meta http-equiv="content-type"
		content="text/html;charset=utf-8" />
	<head>
		<meta charset="utf-8">
		<title>Homepage</title>
		<!-- Viewport-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Favicon and Touch Icons-->
		<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<link rel="manifest" href="site.webmanifest">
		<link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="theme-color" content="#ffffff">
		<!-- Vendor Styles including: Font Icons, Plugins, etc.-->
		<link rel="stylesheet" media="screen"
			href="vendor/simplebar/dist/simplebar.min.css" />
		<link rel="stylesheet" media="screen"
			href="vendor/tiny-slider/dist/tiny-slider.css" />
		<link rel="stylesheet" media="screen"
			href="vendor/drift-zoom/dist/drift-basic.min.css" />
		<!-- Main Theme Styles + Bootstrap-->
		<link rel="stylesheet" media="screen" href="css/theme.min.css">
		
	</head>
	<!-- Body-->
	<body class="handheld-toolbar-enabled">
		<main class="page-wrapper">
			<!-- Navbar 3 Level (Light)-->
			<div id="header"></div>
			<section class="tns-carousel tns-controls-lg">
				<div class="tns-carousel-inner"
					data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;responsive&quot;: {&quot;0&quot;:{&quot;nav&quot;:true, &quot;controls&quot;: false},&quot;992&quot;:{&quot;nav&quot;:false, &quot;controls&quot;: true}}}">
					<!-- Item 1 -->

					<div class="carousel-item px-lg-5" style="background-color: #FFF;">
						<div
							class="d-lg-flex justify-content-between align-items-center ps-lg-4">
							<img class="d-block order-lg-2 me-lg-n5 flex-shrink-0 img_carousel"
								src="https://theme.hstatic.net/200000174405/1001111911/14/slideshow_4.jpg?v=1425"
								alt="Men Accessories">
						</div>
					</div>
					<!-- Item 2 -->
					<div class="carousel-item px-lg-5" style="background-color: #FFF;">
						<a href="#">
							<div
								class="d-lg-flex justify-content-between align-items-center ps-lg-4">
								<img class="d-block order-lg-2 me-lg-n5 flex-shrink-0 img_carousel"
									style="height: 600px; width: auto;"
									src="https://theme.hstatic.net/200000174405/1001111911/14/slideshow_7.jpg?v=1425"
									alt="Men Accessories">
							</div>
						</a>

					</div>
					<!-- Item 3 -->
					<div class="carousel-item px-lg-5" style="background-color: #FFF;">
						<div
							class="d-lg-flex justify-content-between align-items-center ps-lg-4">
							<img class="d-block order-lg-2 me-lg-n5 flex-shrink-0 img_carousel"
								src="https://theme.hstatic.net/200000174405/1001111911/14/slideshow_6.jpg?v=1425"
								alt="Men Accessories">
						</div>
					</div>
				</div>
			</section>

			<!-- Products grid (Trending products)-->
			<section class="container pt-md-3 pb-5 mb-md-3">
				<h2 class="h3 text-center">Sản phẩm nổi bật</h2>
				<div class="row pt-4 mx-n2">

					<?php foreach ($products as $product) { ?>

					<!-- Product-->
					<div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-4">
						<div class="card product-card">
							<a
								class="card-img-top d-block overflow-hidden"
								href="product_detail.php?&product_id=<?php echo $product['product_id'] ?>"><img src="img/shop/catalog/01.jpg"
									alt="Product"></a>
							<div class="card-body py-2"><a
									class="product-meta d-block fs-xs pb-1"><?php echo $product['category_name'] ?></a>
								<h3 class="product-title fs-sm"><a
										href="product_detail.php?&product_id=<?php echo $product['product_id'] ?>"><?php echo $product['name'] ?></a></h3>
								<div class="d-flex justify-content-between">
									<div class="product-price"><span
											class="text-accent"><?php echo (int)$product['price'] ?><small>.000<sup>đ</sup></small></span></div>
								</div>
							</div>
						</div>
						<hr class="d-sm-none">
					</div>
					
					<!-- END- Product-->
					<?php } ?>
					
				</div>
				<div class="text-center pt-3"><a class="btn btn-outline-accent"
						href="shop-grid-ls.html">Sản phẩm khác<i
							class="ci-arrow-right ms-1"></i></a></div>
			</section>
				<!-- Banners-->
				<!-- Featured category (Hoodie)-->

				<!-- Shop by brand-->
				<section class="container py-lg-4 mb-4">
					<h2 class="h3 text-center pb-4">Shop by brand</h2>
					<div class="row">
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/01.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/02.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/03.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/04.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/05.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/06.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/07.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/08.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/09.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/10.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/11.png"
									style="width: 150px;" alt="Brand"></a></div>
						<div class="col-md-3 col-sm-4 col-6"><a
								class="d-block bg-white shadow-sm rounded-3 py-3 py-sm-4 mb-grid-gutter"
								href="#"><img class="d-block mx-auto" src="img/shop/brands/12.png"
									style="width: 150px;" alt="Brand"></a></div>
					</div>
				</section>
				<!-- Blog + Instagram info cards-->
				<section class="container-fluid px-0">
					<div class="row g-0">
						<div class="col-md-6"><a
								class="card border-0 rounded-0 text-decoration-none py-md-4 bg-faded-primary"
								href="blog-list-sidebar.html">
								<div class="card-body text-center"><i
										class="ci-edit h3 mt-2 mb-4 text-primary"></i>
									<h3 class="h5 mb-1">Read the blog</h3>
									<p class="text-muted fs-sm">Latest store, fashion news and
										trends</p>
								</div></a></div>
						<div class="col-md-6"><a
								class="card border-0 rounded-0 text-decoration-none py-md-4 bg-faded-accent"
								href="#">
								<div class="card-body text-center"><i
										class="ci-instagram h3 mt-2 mb-4 text-accent"></i>
									<h3 class="h5 mb-1">Follow on Instagram</h3>
									<p class="text-muted fs-sm">#ShopWithCartzilla</p>
								</div></a></div>
					</div>
				</section>
			</main>
			<!-- Footer-->
			 <div id="footer"></div>
				<!-- Back To Top Button--><a class="btn-scroll-top" href="#top"
					data-scroll><span
						class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i
						class="btn-scroll-top-icon ci-arrow-up"> </i></a>
				<!-- Vendor scrits: js libraries and plugins-->
				<script>
					async function loadComponent(id, file) {
						const response = await fetch(file);
						const html = await response.text();
						document.getElementById(id).innerHTML = html;
					}
		
					loadComponent("header", "header.html");
					loadComponent("footer", "footer.html");
				</script>
				<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
				<script src="vendor/simplebar/dist/simplebar.min.js"></script>
				<script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
				<script
					src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
				<script src="vendor/drift-zoom/dist/Drift.min.js"></script>
				<script src="js/theme.min.js"></script>
			</body>
		</html>
