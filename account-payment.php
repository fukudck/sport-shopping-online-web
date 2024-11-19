<?php
  require_once("php/already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("php/conn.php");
  require_once("php/query_func.php");

  $user_id = $_SESSION['user']['id'];

  $user = getUserData($conn, $user_id);
  $payments = getPayment($conn, $user_id);
  $conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>Phương thức thanh toán</title>
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
      <!-- Add Payment Method-->
      <form class="needs-validation modal fade" action="php/add_payment.php" method="post" id="add-payment" tabindex="-1" novalidate>
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Thêm thẻ mới</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3 mb-2">
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="number" placeholder="Card Number" required>
                  <div class="invalid-feedback">Vui lòng nhập số thẻ!</div>
                </div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                  <div class="invalid-feedback">Vui lòng nhập tên chủ thẻ!</div>
                </div>
                <div class="col-sm-3">
                  <input class="form-control" type="text" name="expiry" placeholder="MM/YY" required 
                    pattern="^(0[1-9]|1[0-2])\/([0-9]{2})$" 
                    title="Vui lòng nhập đúng định dạng MM/YY (Ví dụ: 12/24)">
                  <div class="invalid-feedback">Vui lòng nhập thời hạn của thẻ!</div>
                </div>

                <div class="col-sm-3">
                  <input class="form-control" type="text" name="cvc" placeholder="CVC" required>
                  <div class="invalid-feedback">Vui lòng nhập số CVC!</div>
                </div>
                <div class="col-sm-6">
                  <button class="btn btn-primary d-block w-100" type="submit">Thêm</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      
      <div id="header"></div>
      <!-- Page Title-->
      <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
          <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Trang chủ</a></li>
                <li class="breadcrumb-item text-nowrap"><a href="#">Tài khoản</a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Phương thức thanh toán</li>
              </ol>
            </nav>
          </div>
          <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Phương thức thanh toán của tôi</h1>
          </div>
        </div>
      </div>
      <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
          <!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
            <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
              <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
                <div class="d-md-flex align-items-center">
                  <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><img class="rounded-circle" src="<?php echo htmlspecialchars($user['avatar_img_link'])?>"></div>
                  <div class="ps-md-3">
                    <h3 class="fs-base mb-0"><?php echo htmlspecialchars($user['first_name']) ." ". htmlspecialchars($user['last_name'])?></h3><span class="text-accent fs-sm"><?php echo htmlspecialchars($user['email'])?></span><br><span class="text-dark fs-sm">Ngày đăng ký: <?php echo htmlspecialchars($user['created_at'])?></span>
                  </div>
                </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Menu</a>
              </div>
              <div class="d-lg-block collapse" id="account-menu">
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">Bảng điều khiển</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="account-orders.php"><i class="ci-bag opacity-60 me-2"></i>Danh sách đơn hàng<span class="fs-sm text-muted ms-auto">1</span></a></li>
                </ul>
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">Cài đặt tài khoản</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 " href="account-profile.php"><i class="ci-user opacity-60 me-2"></i>Thông tin tài khoản</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="account-address.php"><i class="ci-location opacity-60 me-2"></i>Danh sách địa chỉ</a></li>
                  <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-payment.php"><i class="ci-card opacity-60 me-2"></i>Phương thức thanh toán</a></li>
                  <li class="d-lg-none border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="logout.php"><i class="ci-sign-out opacity-60 me-2"></i>Đăng xuất</a></li>
                </ul>
              </div>
            </div>
          </aside>
          <!-- Content  -->
          <section class="col-lg-8">
            <!-- Toolbar-->
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
              <h6 class="fs-base text-light mb-0">Phương thức thanh toán chính được sử dụng theo mặc định</h6><a class="btn btn-primary btn-sm" href="account-signin.html"><i class="ci-sign-out me-2"></i>Đăng xuất</a>
            </div>
            <!-- Payment methods list-->
            <div class="table-responsive fs-md mb-4">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Thẻ tín dụng/ghi nợ của bạn</th>
                    <th>Tên chủ thẻ</th>
                    <th>Hết hạn vào</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    foreach ($payments as $payment) {
                    
                    ?>
                  <tr>
                    <td class="py-3 align-middle">
                      <div class="d-flex align-items-center"><img src="img/card-visa.png" width="39" alt="Visa">
                        <div class="ps-2"><span class="fw-medium text-heading me-1">Thẻ</span>**** **** **** <?php echo substr($payment['card_number'], -4);?>
                      </div>
                    </td>
                    <td class="py-3 align-middle"><?php echo $payment['card_holder_name']?></td>
                    <td class="py-3 align-middle"><?php echo date("m/y", strtotime($payment['expiration_date']))?></td>
                    <td class="py-3 align-middle"><a class="nav-link-style text-danger" href="php/delete_payment.php?payment_id=<?php echo $payment['payment_method_id']?>" data-bs-toggle="tooltip" title="Xoá">
                        <div class="ci-trash"></div></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="text-sm-end"><a class="btn btn-primary" href="#add-payment" data-bs-toggle="modal">Thêm thẻ mới</a></div>
          </section>
        </div>
      </div>
    </main>
    <!-- Footer-->
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
    <!-- Back To Top Button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
  </body>

<!-- Mirrored from cartzilla.createx.studio/account-payment.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Oct 2023 15:50:39 GMT -->
</html>