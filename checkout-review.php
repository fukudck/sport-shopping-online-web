<?php 
  require_once("php/already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("php/conn.php");
  require_once("php/query_func.php");
  require_once('php/cart_process.php');
  $user_id = $_SESSION['user']['id'];
  $cart_items = displayCartItems($conn, $user_id);
  $addresses = getAddress($conn, $user_id);
  $payments = getPayment($conn, $user_id);  

  if(!isset($_SESSION['cart']['address'])) {
    header("Location: checkout-details.php");
    exit();
  }
  if(isset($_GET['payment_id'])) {
    $flag = false;
    foreach ($payments as $payment) {
      if ($payment['payment_method_id'] == $_GET['payment_id']) {
        $flag = true;
        $_SESSION['cart']['payment'] = $_GET['payment_id'];
        header("Location: " . $_SERVER['PHP_SELF']);
        break;
      }
    }
    if(!$flag) {
      header("Location : checkout-payment.php");
      exit();
    }
  } else {
      if(!isset($_SESSION['cart']['payment'])) {
        header("Location : checkout-payment.php");
        exit();
      }
  }
  $sql1="SELECT * FROM user_payment_methods WHERE user_id = ? AND payment_method_id = ?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param("ii", $user_id, $_SESSION['cart']['payment']);
  $stmt1->execute();
  $result1 = $stmt1->get_result();
  $payment= $result1->fetch_assoc();

  $sql2="SELECT * FROM user_shipping_addresses  WHERE user_id = ? AND address_id = ?";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param("ii", $user_id, $_SESSION['cart']['address']);
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  $address= $result2->fetch_assoc();
  




?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>Thanh toán</title>
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
    <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen" href="vendor/tiny-slider/dist/tiny-slider.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="css/theme.min.css">
  </head>
  <!-- Body-->
  <body>
    <main class="page-wrapper">
      <div id="header"></div>
      <!-- Page Title-->
      <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
          <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item"><a class="text-nowrap" href="home.html"><i class="ci-home"></i>Trang chủ</a></li>
                <li class="breadcrumb-item text-nowrap"><a href="cart.html">Giỏ hàng</a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Thanh toán</li>
              </ol>
            </nav>
          </div>
          <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Thanh toán</h1>
          </div>
        </div>
      </div>
      <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          <section class="col-lg-8">
            <!-- Steps-->
            <div class="steps steps-light pt-2 pb-3 mb-5">
              <a class="step-item active" >
                <div class="step-progress"><span class="step-count">1</span></div>
                <div class="step-label"><i class="ci-cart"></i>Giỏ hàng</div>
              </a>
              <a class="step-item active" >
                <div class="step-progress"><span class="step-count">2</span></div>
                <div class="step-label"><i class="ci-user-circle"></i>Địa chỉ</div>
              </a>
              <a class="step-item active">
                <div class="step-progress"><span class="step-count">3</span></div>
                <div class="step-label"><i class="ci-package"></i>Thanh toán</div>
              </a>
              <a class="step-item active current">
                <div class="step-progress"><span class="step-count">4</span></div>
                <div class="step-label"><i class="ci-check-circle"></i>Xác nhận</div>
              </a>
              </div> 
            <!-- Order details-->
            <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Xác nhận lại đơn hàng</h2>
            <?php foreach ($cart_items as $item): ?>
            <!-- Item-->
            <div class="d-sm-flex justify-content-between my-4 pb-3 border-bottom">
              <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" ><img src="<?= $item['image_url']; ?>" width="160" alt="Product"></a>
                <div class="pt-2">
                  <h3 class="product-title fs-base mb-2"><a ><?= $item['name']; ?></a></h3>
                  <div class="fs-sm"><span class="text-muted me-2">Kích cỡ:</span><?= $item['size']; ?></div>
                  <div class="fs-lg text-accent pt-2"><?= number_format($item['price'], 3); ?> <small>VND</small></div>
                </div>
              </div>
              <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-end" style="max-width: 9rem;">
                <p class="mb-0"><span class="text-muted fs-sm">Số Lượng:</span><span>&nbsp;1</span></p>
                
              </div>
            </div>
            <?php endforeach; ?>
            <!-- Client details-->
            <div class="bg-secondary rounded-3 px-4 pt-4 pb-2">
              <div class="row">
                <div class="col-sm-6">
                  <h4 class="h6">Giao cho:</h4>
                  <ul class="list-unstyled fs-sm">
                    <li><span class="text-muted">Khánh hàng:&nbsp;</span><?php echo $address['first_name']." ".$address['last_name']?></li>
                    <li><span class="text-muted">Địa chỉ:&nbsp;</span><?php echo convertAddressIdsToNames($address);?></li>
                    <li><span class="text-muted">SĐT:&nbsp;</span><?php echo $address['phone_number']?></li>
                  </ul>
                </div>
                <div class="col-sm-6">
                  <h4 class="h6">Phương thức thanh toán:</h4>
                  <ul class="list-unstyled fs-sm">
                    <li><span class="text-muted">Thẻ:&nbsp;</span>**** **** **** <?php echo substr($payment['card_number'], -4);?></li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- Navigation (desktop)-->
            <div class="d-none d-lg-flex pt-4">
              <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="checkout-payment.php"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Quay lại thanh toán</span><span class="d-inline d-sm-none">Quay lại</span></a></div>
              <div class="w-50 ps-2"><a class="btn btn-primary d-block w-100" href="checkout-complete.php"><span class="d-none d-sm-inline">Đặt hàng</span><span class="d-inline d-sm-none">Đặt hàng</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></a></div>
            </div>
          </section>
          <!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
            <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
              <div class="py-2 px-xl-2">
                <h2 class="h6 text-center mb-4">Đơn hàng của bạn</h2>
                
                <h3 class="fw-normal text-center my-4"><?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['cart_quantity'], $cart_items)), 3); ?> VND </h3>
                
              </div>
            </div>
          </aside>
        </div>
      </div>
    </main>
    <!-- Footer-->
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
    <!-- Quay ve dau trang--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
  </body>
</html>