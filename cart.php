<?php
  require_once('php/cart_process.php');
  $cart_items = displayCartItems($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>Giỏ hàng của bạn</title>
    
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="css/theme.min.css">
    
</head>

<body class="handheld-toolbar-enabled">
    <main class="page-wrapper">
        <div id="header"></div> 

        <!-- Page Title-->
        <div class="page-title-overlap bg-dark pt-4">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="home.html"><i class="ci-home"></i>Trang chủ</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">Giỏ hàng</li>
                        </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="h3 text-light mb-0">Giỏ hàng của bạn</h1>
                </div>
            </div>
        </div>

        <div class="container pb-5 mb-2 mb-md-4">
            <div class="row">
                <!-- List of items-->
                <section class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1">
                        <h2 class="h6 text-light mb-0">Sản Phẩm</h2><a class="btn btn-outline-primary btn-sm ps-2" href="shop-grid-ls.html"><i class="ci-arrow-left me-2"></i>Tiếp tục mua sắm</a>
                    </div>
                    <div id="cart-container" >
                    <?php foreach ($cart_items as $item): ?>
                        <!-- Item-->
                        <div class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom">
                            <div class="d-block d-sm-flex align-items-center text-center text-sm-start">
                                <a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="shop-single-v1.html">
                                    <img src="<?= $item['image_url']; ?>" width="160" alt="Product">
                                </a>
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2">
                                        <a href="shop-single-v1.html"><?= $item['name']; ?></a>
                                    </h3>
                                    <div class="fs-sm">
                                        <span class="text-muted me-2">Kích cỡ:</span><?= $item['size']; ?>
                                    </div>
                                    <div class="fs-lg text-accent pt-2"><?= number_format($item['price'], 2); ?> <small>VND</small></div>
                                </div>
                            </div>
                            <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                                <label class="form-label" for="quantity1">Số lượng</label>
                                <input  class="quantity-input form-control" type="number" id="quantity1" min="1" value="<?= $item['cart_quantity']; ?>">
                                <button data-cart-item-id="<?php echo $item['cart_item_id']; ?>" id="ondelete" class="btn btn-link px-0 text-danger" type="button"><i class="ci-close-circle me-2"></i><span class="fs-sm">Xóa</span></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <button id="refresh" class="btn btn-outline-accent d-block w-100 mt-4" type="button"><i class="ci-loading fs-base me-2"></i>Cập nhật giỏ hàng</button>
                </section>

                <!-- Sidebar-->
                <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
                    <div class="bg-white rounded-3 shadow-lg p-4">
                        <div class="py-2 px-xl-2">
                            <div class="text-center mb-4 pb-3 border-bottom">
                                <h2 class="h6 mb-3 pb-1">Tổng cộng</h2>
                                <h3 class="fw-normal" id="total-price"><?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['cart_quantity'], $cart_items)), 2); ?> VND </h3>
                            </div>
                            <div class="mb-3 mb-4">
                                <label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Ghi chú</span><span class="fw-medium">Để lại lời nhắn</span></label>
                                <textarea class="form-control" rows="6" id="order-comments"></textarea>
                            </div>
                            <a class="btn btn-primary btn-shadow d-block w-100 mt-4" href="checkout-details.html"><i class="ci-card fs-lg me-2"></i>Tiến hành thanh toán</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <div id="footer"></div>
    <script>
        async function loadComponent(id, file) {
            const response = await fetch(file);
            const html = await response.text();
            document.getElementById(id).innerHTML = html;
        }
        loadComponent("header", "header.html");
        loadComponent("footer", "footer.html");
    </script>

    <!-- Quay ve dau trang-->
    <a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up"></i></a>

    <!-- Main theme script-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script></script>
    <script src="./cart/cart.js"></script>

    <script src="./js/theme.min.js"></script>
</body>
</html>
