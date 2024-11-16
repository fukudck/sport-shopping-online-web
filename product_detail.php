<?php 
	require_once('php/conn.php');
	require('php/query_func.php');

	if (!isset($_GET['product_id'])) {
		header("Location: product.php");
	}

	$product_details  = getProductDetails($conn, $_GET['product_id']);

	$also_like_products = getRandomProducts($conn, $product_details['category_id']);

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $product_details['name'] ?></title>
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
							<li class="breadcrumb-item active text-light" aria-current="page"><?php echo $product_details['name'] ?></li>
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
										foreach ($product_details['image_urls'] as $image) { ?>
											<div class="product-gallery-preview-item <?php if (!$flag) { echo 'active'; $flag = true;} ?>" id="product_image_<?php echo $image['image_id'] ?>"><img class="image-zoom" src="<?php echo $image['image_url'] ?>" alt="Product image">
											</div>
										
										<?php } ?>
									</div>
									<div class="product-gallery-thumblist order-sm-1">
										<?php 
										$flag = false;
										foreach ($product_details['image_urls'] as $image) { ?>
										<a class="product-gallery-thumblist-item <?php if (!$flag) { echo 'active'; $flag = true;} ?>" href="#product_image_<?php echo $image['image_id'] ?>">
											<img src="<?php echo $image['image_url'] ?>" ></a>
										<?php } ?>
									</div>
								</div>
							</div>
							<!-- Product details-->
							<div class="col-lg-5 pt-4 pt-lg-0">
								
								<div class="product-details ms-auto pb-3">
									<div
										class="product-info d-flex justify-content-between align-items-center mb-3">
										<h1 class="product-title h4 mb-0 text-center text-md-start"><?php echo $product_details['name'] ?></h1>
											
									</div>
									<div class="price-display mb-3">
										
										<span class="product-detail-price h3 fw-bold text-accent me-1"><?php echo (int)$product_details['price'] ?>.000<sup>đ</sup></span>
										<div class="badge <?php echo ($product_details['stock_quantity']>0) ? 'bg-success' : 'bg-danger'; ?> badge-shadow d-md-inline-block text-center" style=" height: 25px; line-height: 25px"><i class="<?php echo ($product_details['stock_quantity']>0) ? 'ci-security-check' : 'ci-security-close'; ?>"></i> <?php echo ($product_details['stock_quantity']>0) ? 'Còn hàng' : 'Hết hàng'; ?></div>


									</div>
									<form class="mb-grid-gutter" action method="post">
										<div class="mb-3">
											<div class="d-flex justify-content-between align-items-center pb-1">
												<label class="form-label" for="product-size">Bảng hướng dẫn kích
													cỡ</label><a class="nav-link-style fs-sm" href="#size-chart"
													data-bs-toggle="modal"><i
														class="ci-ruler lead align-middle me-1 mt-n1"></i>Xem</a>											
											</div>
											<select class="form-select" id="product-size" 
												<?php 
													// Kiểm tra nếu có "No Size", nếu có thì ẩn dropdown
													if (in_array("No Size", array_column($product_details['sizes'], 'size'))) {
														echo 'hidden'; // Ẩn dropdown nếu có "No Size"
													} else {
														echo 'required'; // Nếu không có "No Size", đánh dấu dropdown là required
													}
												?>>
												<option value="" disabled selected>Chọn size</option>
												<?php foreach ($product_details['sizes'] as $size) { ?>
													<option value="<?php echo htmlspecialchars($size['size']) ?>"><?php echo htmlspecialchars($size['size']) ?></option>
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
												type="submit" <?php echo ($product_details['stock_quantity']>0) ? '' : 'disabled'; ?>><i class="ci-cart fs-lg me-2" ></i>Thêm vào giỏ
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
														<li><?php echo $product_details['description'] ?></li>
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
								<!-- Product -->
								<div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-4">
									<div class="card product-card card_container h-100">
										<a href="product_detail.php?&product_id=<?php echo $also_like_product['product_id'] ?>" class="card-img-top">
											<img class="image_product img-fluid" src="<?php echo $also_like_product['image_url'] ?>" alt="Product">
										</a>
										<div class="card-body py-3">
											<a class="product-meta d-block fs-xs pb-1"><?php echo $also_like_product['category_name'] ?></a>
											<h3 class="product-title fs-sm ">
												<a href="product_detail.php?&product_id=<?php echo $also_like_product['product_id'] ?>">
													<?php echo $also_like_product['name'] ?>
												</a>
											</h3>
											<div class="d-flex justify-content-between">
												<div class="product-price">
													<span class="text-accent">
														<?php echo (int)$also_like_product['price'] ?><small>.000<sup>đ</sup></small>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- END- Product -->
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