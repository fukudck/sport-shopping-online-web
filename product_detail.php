<?php 
	require_once('php/conn.php');
	if (!isset($_GET['product_id'])) {
		header("Location: product.php");
	}

	$sql = "SELECT * FROM products WHERE product_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $_GET['product_id']);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) { 
	$product = $result->fetch_assoc();
	$sizes = json_decode($product['sizes']);
	}
	else {
		header("Location: product.php");
	}
	$image_sql = "SELECT image_url, image_id FROM product_images WHERE product_id = ?";
	$image_sql_stmt = $conn->prepare($image_sql);
	$image_sql_stmt->bind_param("i", $_GET['product_id']);
	$image_sql_stmt->execute();
	$image_sql_result = $image_sql_stmt->get_result();
	$image_urls = array();

	// Lấy tất cả các hình ảnh vào mảng
	while ($row = $image_sql_result->fetch_assoc()) {
		$image_urls[] = $row;
	}


  	// 8 SP ngẫu nhiên cùng category
	$also_like_stmt = $conn->prepare("
		SELECT p.*, c.category_name , pi.image_url
		FROM products p 
		JOIN categories c ON p.category_id = c.category_id 
		LEFT JOIN (
			SELECT product_id, MIN(image_url) AS image_url
			FROM product_images
			GROUP BY product_id
		) pi ON p.product_id = pi.product_id
		WHERE p.category_id = ".$product['category_id']."
		ORDER BY RAND() 
		LIMIT 8
	");
	$also_like_stmt->execute();
	$also_like_result = $also_like_stmt->get_result();

	$also_like_products = []; // Khởi tạo mảng để lưu trữ sản phẩm

	while ($row = $also_like_result->fetch_assoc()) {
		$also_like_products[] = $row; // Thêm từng dòng vào mảng
	}



?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $product['name'] ?></title>
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
		<link rel="stylesheet" media="screen"
			href="vendor/lightgallery/css/lightgallery-bundle.min.css" />
		<!-- Main Theme Styles + Bootstrap-->
		<link rel="stylesheet" media="screen" href="css/theme.min.css">
	</head>
	<!-- Body-->
	<body class="handheld-toolbar-enabled">
		<main class="page-wrapper">
			<!-- bảng size modal fade-->
			<div class="modal fade" id="size-chart">
				<div class="modal-dialog modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header bg-secondary">
							<a><img
									src="https://bizweb.dktcdn.net/100/438/408/files/2705-bangsize-01-449f9e67-9d72-42e3-b72d-67f04c29c31e.jpg?v=1653646530679" /></a>
						</div>

					</div>
				</div>
			</div>
			<!-- Header -->
			<div id="header"></div>
			<!-- End Header -->
			<!-- Page Title-->
			<div class="bg-dark text-white py-4">
				<div
					class="container d-flex flex-column flex-md-row align-items-center">
					<!-- Breadcrumbs -->
					<nav aria-label="breadcrumb" class="mb-2 mb-md-0">
						<ol class="breadcrumb breadcrumb-dark mb-0">
							<li class="breadcrumb-item"><a href="index.html" class="text-light"><i
										class="ci-home"></i> Trang chủ</a></li>
							<li class="breadcrumb-item"><a href="#" class="text-light">Sản
									phẩm</a></li>
							<li class="breadcrumb-item active text-light" aria-current="page"><?php echo $product['name'] ?></li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="container">
				<!-- Gallery + details-->
				<div class="bg-light shadow-lg rounded-3 px-4 py-3 mb-5">
					<div class="px-lg-3">
						<div class="row">
							<!-- Product gallery-->
							<div class="col-lg-7 pe-lg-0 pt-lg-4">
								<div class="product-gallery">
									<div class="product-gallery-preview order-sm-2">
										<?php 
										$flag = false;
										foreach ($image_urls as $image) { ?>
											<div class="product-gallery-preview-item <?php if (!$flag) { echo 'active'; $flag = true;} ?>" id="product_image_<?php echo $image['image_id'] ?>"><img class="image-zoom" src="<?php echo $image['image_url'] ?>" alt="Product image">
											</div>
										
										<?php } ?>
									</div>
									<div class="product-gallery-thumblist order-sm-1">
										<?php 
										$flag = false;
										foreach ($image_urls as $image2) { ?>
										<a class="product-gallery-thumblist-item <?php if (!$flag) { echo 'active'; $flag = true;} ?>" href="#product_image_<?php echo $image2['image_id'] ?>">
											<img src="<?php echo $image2['image_url'] ?>" ></a>
										<?php } ?>
									</div>
								</div>
							</div>
							<!-- Product details-->
							<div class="col-lg-5 pt-4 pt-lg-0">
								
								<div class="product-details ms-auto pb-3">
									<div
										class="product-info d-flex justify-content-between align-items-center mb-3">
										<h1 class="product-title h4 mb-0 text-center text-md-start"><?php echo $product['name'] ?></h1>
											
									</div>
									<div class="price-display mb-3">
										
										<span class="product-detail-price h3 fw-bold text-accent me-1"><?php echo (int)$product['price'] ?>.000<sup>đ</sup></span>
										<div class="badge <?php echo ($product['stock_quantity']>0) ? 'bg-success' : 'bg-danger'; ?> badge-shadow d-md-inline-block text-center" style=" height: 25px; line-height: 25px"><i class="<?php echo ($product['stock_quantity']>0) ? 'ci-security-check' : 'ci-security-close'; ?>"></i> <?php echo ($product['stock_quantity']>0) ? 'Còn hàng' : 'Hết hàng'; ?></div>


									</div>
									<form class="mb-grid-gutter" action method="post">
										<div class="mb-3">
											<div class="d-flex justify-content-between align-items-center pb-1">
												<label class="form-label" for="product-size">Bảng hướng dẫn kích
													cỡ</label><a class="nav-link-style fs-sm" href="#size-chart"
													data-bs-toggle="modal"><i
														class="ci-ruler lead align-middle me-1 mt-n1"></i>Xem</a>											
											</div>
											<select class="form-select" id="product-size" <?php if (empty($sizes)) { echo 'hidden';} else {echo 'required';}?>>
												<option value>Chọn size</option>
												<?php foreach ($sizes as $size) { ?>
													<option value="<?php echo htmlspecialchars($size)?>"><?php echo htmlspecialchars($size)?></option>
													
												<?php } ?>
											</select>
										</div>
										<div class="mb-3 d-flex align-items-center">
											<div class="d-flex">
												
												<button class="btn btn-outline-secondary" type="button"
													onclick="decreaseQuantity()">-</button>
												<input type="text" class="form-control text-center" id="quantity"
													name="quantity" value="1" readonly>
												<button class="btn btn-outline-secondary" type="button"
													onclick="increaseQuantity()">+</button>
											</div>
											<!-- JS tăng giảm tự động -->
											<script>
												function increaseQuantity() {
													const quantityInput = document.getElementById("quantity");
													let currentQuantity = parseInt(quantityInput.value);
													quantityInput.value = currentQuantity + 1;
												}
											
												function decreaseQuantity() {
													const quantityInput = document.getElementById("quantity");
													let currentQuantity = parseInt(quantityInput.value);
													if (currentQuantity > 1) { 
														quantityInput.value = currentQuantity - 1;
													}
												}
											</script>
											<button class="btn btn-accent btn-shadow d-block w-100"
												type="submit" <?php echo ($product['stock_quantity']>0) ? '' : 'disabled'; ?>><i class="ci-cart fs-lg me-2" ></i>Thêm vào giỏ
												hàng</button>
										</div>
									</form>
									<!-- Mô tả sản phẩm-->
									<div class="accordion product-accordion mb-4" id="productPanels">
										<div class="accordion-item">
											<h3 class="accordion-header">
												<a class="accordion-button" href="#productInfo" role="button"
													data-bs-toggle="collapse" aria-expanded="true"
													aria-controls="productInfo">
													<i
														class="ci-announcement text-muted fs-lg align-middle me-2"></i>Thông
													tin sản phẩm
												</a>
											</h3>
											<div class="accordion-collapse collapse show" id="productInfo"
												data-bs-parent="#productPanels">
												<div class="accordion-body">
													<ul class="fs-sm ps-4">
														<li><?php echo $product['description'] ?></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="accordion-item">
											<h3 class="accordion-header">
												<a class="accordion-button collapsed" href="#shippingOptions"
													role="button" data-bs-toggle="collapse" aria-expanded="true"
													aria-controls="shippingOptions">
													<i class="ci-delivery text-muted lead align-middle me-2"></i>Lựa
													chọn vận chuyển
												</a>
											</h3>
											<div class="accordion-collapse collapse" id="shippingOptions"
												data-bs-parent="#productPanels">
												<div class="accordion-body fs-sm">
													<div class="d-flex justify-content-between border-bottom py-2">
														<div>
															<div class="fw-semibold text-dark">Giao hàng tiết kiệm</div>
															<div class="fs-sm text-muted">3 - 5 ngày</div>
														</div>
														<div>25.000đ</div>
													</div>
													<div class="d-flex justify-content-between border-bottom py-2">
														<div>
															<div class="fw-semibold text-dark">Giao hàng nhanh</div>
															<div class="fs-sm text-muted">2 - 3 ngày</div>
														</div>
														<div>35.000đ</div>
													</div>
													<!-- Shipping options content here -->
												</div>
											</div>
										</div>
										<!--  Tạm thời không dùng <div class="accordion-item">
											<h3 class="accordion-header">
												<a class="accordion-button collapsed" href="#localStore"
													role="button" data-bs-toggle="collapse" aria-expanded="true"
													aria-controls="localStore">
													<i class="ci-location text-muted fs-lg align-middle me-2"></i>Cửa
													hàng gần đây
												</a>
											</h3>
											<div class="accordion-collapse collapse" id="localStore"
												data-bs-parent="#productPanels">
												<div class="accordion-body">
													<select class="form-select">
														<option>TP Hồ Chí Minh</option>
														<option>Đà Nẵng</option>
														<option>Hà Nội</option>
													</select>
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
						<!-- Product description section 1-->

						<!-- Product END description section 1-->
						
					</div>
					<!-- Product carousel (You may also like)-->
					<div class="container py-5 my-md-3">
						<h2 class="h3 text-center pb-4">Bạn có thể thích</h2>
						<div class="tns-carousel tns-controls-static tns-controls-outside">
							<div class="tns-carousel-inner"
								data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: true, &quot;nav&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;768&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 30}}}">
								<!-- Product-->
								<?php foreach ($also_like_products as $also_like_product) { ?>
								<div>
									<div class="card product-card card-static border">
										<a class="card-img-top d-block overflow-hidden" href="product_detail.php?&product_id=<?php echo $also_like_product['product_id'] ?>">
											<img src="<?php echo $also_like_product['image_url'] ?>" alt="Product">
										</a>
										<div class="card-body py-2">
											<a
												class="product-meta d-block fs-xs pb-1 text-decoration-none text-muted">
												<?php echo $also_like_product['category_name'] ?>
											</a>
											<h3 class="product-title fs-sm mb-2">
												<a href="product_detail.php?&product_id=<?php echo $also_like_product['product_id'] ?>" class="text-dark text-decoration-none"><?php echo $also_like_product['name'] ?></a>
											</h3>
											<div class="d-flex justify-content-between align-items-center">
												<div class="product-price">
												<div class="product-price"><span
													class="text-accent"><?php echo (int)$also_like_product['price'] ?><small>.000<sup>đ</sup></small></span></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<!-- Product-->
								
							</div>
						</div>
					</div>
				</main>
				<!-- Footer-->
				<div id="footer"></div>
				<!-- Toolbar for handheld devices (Default)-->
				<div class="handheld-toolbar">
					<div class="d-table table-layout-fixed w-100">
						<a
							class="d-table-cell handheld-toolbar-item" href="javascript:void(0)"
							data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
							onclick="window.scrollTo(0, 0)"><span class="handheld-toolbar-icon"><i
									class="ci-menu"></i></span><span
								class="handheld-toolbar-label">Menu</span></a>
						<a
							class="d-table-cell handheld-toolbar-item" href="#"><span
								class="handheld-toolbar-icon"><i class="ci-cart"></i><span
									class="badge bg-primary rounded-pill ms-1">4</span></span><span
								class="handheld-toolbar-label">$265.00</span></a></div>
				</div>
				<!-- Back To Top Button--><a class="btn-scroll-top" href="#top"
					data-scroll><span
						class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i
						class="btn-scroll-top-icon ci-arrow-up"> </i></a>
				<script>
							async function loadComponent(id, file) {
								const response = await fetch(file);
								const html = await response.text();
								document.getElementById(id).innerHTML = html;
							}
				
							loadComponent("header", "header.html");
							loadComponent("footer", "footer.html");
						</script>
				<!-- Vendor scrits: js libraries and plugins-->
				<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
				<script src="vendor/simplebar/dist/simplebar.min.js"></script>
				<script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
				<script
					src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
				<script src="vendor/drift-zoom/dist/Drift.min.js"></script>
				<script src="vendor/lightgallery/lightgallery.min.js"></script>
				<script src="vendor/lightgallery/plugins/video/lg-video.min.js"></script>
				<script src="js/theme.min.js"></script>
			</body>

		</html>