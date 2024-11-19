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
  $selected_payment_id = NULL;
  if(isset($_GET['payment_id'])) {
    $selected_payment_id = $_GET['payment_id'];
  }

  if(isset($_GET['address_id'])) {
    $flag = false;
    foreach ($addresses as $address) {
      if ($address['address_id'] == $_GET['address_id']) {
        $flag = true;
        $_SESSION['cart']['address'] = $_GET['address_id'];
        header("Location: " . $_SERVER['PHP_SELF']);
        break;
      }
    }
    if(!$flag) {
      header("Location: checkout-details.php");
      exit();
    }
  } else {
      if(!isset($_SESSION['cart']['address'])) {
        header("Location: checkout-details.php");
        exit();
      }
  }
  $payments = getPayment($conn, $user_id);


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
    <script>
        function formatInput(input) {
            const value = input.value.replace(/\D/g, ""); // Xóa các ký tự không phải số
            input.value = value.padStart(3, "0"); // Thêm 0 vào đầu cho đủ 3 chữ số
        }
    </script>
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
              <a class="step-item active current" >
                <div class="step-progress"><span class="step-count">3</span></div>
                <div class="step-label"><i class="ci-package"></i>Thanh toán</div>
              </a>
              <a class="step-item" >
                <div class="step-progress"><span class="step-count">4</span></div>
                <div class="step-label"><i class="ci-check-circle"></i>Xác nhận</div>
              </a>
            </div>              
            <!-- Payment methods-->

            <div class="accordion accordion-flush" id="accordionFlushExample">

            <!-- Item -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">Chọn thẻ ngân hàng</button>
              </h2>
              <div class="accordion-collapse collapse show" id="flush-collapseOne" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <form class="needs-validation" method="get" novalidate action="checkout-review.php">
                  <div class="mb-5">
                    <label for="select-input" class="form-label"></label>
                    <select class="form-select" id="select-input" required name="payment_id">
                      <option value="" <?php if(!isset($selected_payment_id)) echo "selected"?> disabled>Chọn thẻ..</option>
                      <?php 
                        foreach ($payments as $payment) {
                      ?>
                      <option  <?php if($payment['payment_method_id'] == $selected_payment_id) echo "selected"?> value="<?php echo $payment['payment_method_id']?>"><div class="ps-2">**** **** **** <?php echo substr($payment['card_number'], -4)." - ".$payment['card_holder_name']?></div></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="d-none d-lg-flex pt-4 mt-3">
                    <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="checkout-details.php"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Chỉnh sửa địa chỉ</span></a></div>
                    <div class="w-50 ps-2">
                      <button class="btn btn-primary d-block w-100" type="submit">
                        <span class="d-none d-sm-inline">Xác nhận đơn hàng</span>
                        <i class="ci-arrow-right mt-sm-0 ms-1"></i>
                      </button>
                    </div>

                  </div>
                </form>

                </div>
              </div>
            </div>

            <!-- Item -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">Thêm thẻ ngân hàng</button>
              </h2>
              <div class="accordion-collapse collapse" id="flush-collapseTwo" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div id="payment-method">
                  <p class="fs-sm">Chúng tôi chấp nhận các thẻ sau:&nbsp;&nbsp;<img class="d-inline-block align-middle" src="img/cards.png" width="187" alt="Cerdit Cards"></p>
                    <form class="credit-card-form row needs-validation" action="php/add_payment.php" method="post" novalidate>
                      <div class="mb-3 col-sm-6">
                        <input class="form-control" type="text" name="number" placeholder="Số thẻ" required>
                        <div class="invalid-feedback">Vui lòng nhập số thẻ!</div>
                      </div>
                      <div class="mb-3 col-sm-6">
                        <input class="form-control" type="text" name="name" placeholder="Tên chủ thẻ" required>
                        <div class="invalid-feedback">Vui lòng nhập tên chủ thẻ!</div>
                      </div>
                      <div class="mb-3 col-sm-3">
                        <input class="form-control" type="text" name="expiry" placeholder="MM/YY" required 
                            pattern="^(0[1-9]|1[0-2])\/([0-9]{2})$" 
                            title="Vui lòng nhập đúng định dạng MM/YY (Ví dụ: 12/24)">
                            <div class="invalid-feedback">Vui lòng nhập thời hạn của thẻ!</div>
                      </div>
                      <div class="mb-3 col-sm-3">
                        <input class="form-control" type="text" name="cvc" placeholder="Số CVC" required maxlength="3" onblur="formatInput(this)">
                        <div class="invalid-feedback">Vui lòng nhập số CVC!</div>
                      </div>
                      <div class="col-sm-6">
                        <button class="btn btn-outline-primary d-block w-100 mt-0" type="submit">Thêm</button>
                      </div>
                    </form>
                </div>
                </div>
              </div>
            </div>
            </div>

          </section>
          <!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
            <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
              <div class="py-2 px-xl-2">
                <div class="widget mb-3">
                  <h2 class="widget-title text-center">Đơn hàng của bạn</h2>

                  <?php foreach ($cart_items as $item): ?>
                  <div class="d-flex align-items-center pb-2 border-bottom"><a class="d-block flex-shrink-0" href="#"><img src="<?= $item['image_url']; ?>" width="64" alt="Product"></a>
                    <div class="ps-2">
                      <h6 class="widget-product-title"><a><?= $item['name']; ?></a></h6>
                      <div class="widget-product-meta"><span class="text-accent me-2"><?= number_format($item['price'], 3); ?> <small>VND</small></span><span class="text-muted">x <?= $item['cart_quantity']; ?></span></div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
                <h4 class="fw-normal text-center my-4">Tổng tiền</h4>
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
    <script src="vendor/card/dist/card.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
  </body>
</html>