<?php
  require_once("php/already_signin.php");
  if (!isLoggedIn()) {
    header("Location: account-signin.php");
    exit();
  }
  require_once("php/conn.php");

  $user_id = $_SESSION['user']['id'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $user_id); // "i" cho số nguyên
  $stmt->execute();

  // Lấy kết quả
  $result = $stmt->get_result();

  // Kiểm tra xem có kết quả không
  if ($result->num_rows > 0) {
      // Lấy dữ liệu người dùng
      $user = $result->fetch_assoc();
      
      // // In ra thông tin người dùng
      // echo "Họ: " . htmlspecialchars($user['first_name']) . "<br>";
      // echo "Tên: " . htmlspecialchars($user['last_name']) . "<br>";
      // echo "Email: " . htmlspecialchars($user['email']) . "<br>";
      // echo "Số điện thoại: " . htmlspecialchars($user['phone_number']) . "<br>";
  }

// Đóng kết nối
$stmt->close();
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>Thông tin tài khoản</title>
    
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
  <body class="handheld-toolbar-enabled">
    <main class="page-wrapper">
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Thông tin tài khoản</li>
              </ol>
            </nav>
          </div>
          <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Thông tin tài khoản</h1>
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
                  <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><span class="badge bg-warning position-absolute end-0 mt-n2" data-bs-toggle="tooltip" title="Reward points">384</span><img class="rounded-circle" src="<?php echo htmlspecialchars($user['avatar_img_link'])?>"></div>
                  <div class="ps-md-3">
                    <h3 class="fs-base mb-0"><?php echo htmlspecialchars($user['first_name']) ." ". htmlspecialchars($user['last_name'])?></h3><span class="text-accent fs-sm"><?php echo htmlspecialchars($user['email'])?></span>
                  </div>
                </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Account menu</a>
              </div>
              <div class="d-lg-block collapse" id="account-menu">
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">Cài đặt tài khoản</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="account-profile.html"><i class="ci-user opacity-60 me-2"></i>Thông tin tài khoản</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-address.html"><i class="ci-location opacity-60 me-2"></i>Danh sách địa chỉ</a></li>
                  <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-payment.html"><i class="ci-card opacity-60 me-2"></i>Phương thức thanh toán</a></li>
                  <li class="d-lg-none border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-signin.html"><i class="ci-sign-out opacity-60 me-2"></i>Sign out</a></li>
                </ul>
              </div>
            </div>
          </aside>
          <!-- Content  -->
          <section class="col-lg-8">
            <!-- Toolbar-->
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
              <h6 class="fs-base text-light mb-0">Cập nhật thông tin cá nhân bên dưới:</h6><a class="btn btn-primary btn-sm" href="logout.php"><i class="ci-sign-out me-2"></i>Đăng xuất</a>
            </div>
            <!-- Profile form-->
            <form>
              <div class="bg-secondary rounded-3 p-4 mb-4">
                <div class="d-flex align-items-center"><img class="rounded" src="<?php echo htmlspecialchars($user['avatar_img_link'])?>" width="90">
                  <div class="ps-3">
                    <button class="btn btn-light btn-shadow btn-sm mb-2" type="button"><i class="ci-loading me-2"></i>Thay ảnh</button>
                    <div class="p mb-0 fs-ms text-muted">Tải lên hình ảnh JPG, GIF hoặc PNG. Yêu cầu kích thước 300 x 300.</div>
                  </div>
                </div>
              </div>
              <div class="row gx-4 gy-3">
                <div class="col-sm-6">
                  <label class="form-label" for="account-fn">Họ và tên đệm</label>
                  <input class="form-control" type="text" id="account-fn" value="<?php echo htmlspecialchars($user['first_name'])?>">
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-ln">Tên</label>
                  <input class="form-control" type="text" id="account-ln" value="<?php echo htmlspecialchars($user['last_name'])?>">
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-email">Địa chỉ Email</label>
                  <input class="form-control" type="email" id="account-email" value="<?php echo htmlspecialchars($user['email'])?>" disabled>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-phone">Số điện thoại</label>
                  <input class="form-control" type="text" id="account-phone" value="<?php echo htmlspecialchars($user['phone_number'])?>" required>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-pass">Mật khẩu mới</label>
                  <div class="password-toggle">
                    <input class="form-control" type="password" id="account-pass">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                      <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                    </label>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="account-confirm-pass">Nhập lại mật khẩu</label>
                  <div class="password-toggle">
                    <input class="form-control" type="password" id="account-confirm-pass">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                      <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                    </label>
                  </div>
                </div>
                <div class="col-12">
                  <hr class="mt-2 mb-3">
                    <div class="text-end">
                      <button class="btn btn-primary mt-3 mt-sm-0" type="button">Cập nhật</button>
                    </div>
                </div>
              </div>
            </form>
          </section>
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
    <!-- Toolbar for handheld devices (Default)-->
    <div class="handheld-toolbar">
      <div class="d-table table-layout-fixed w-100"><a class="d-table-cell handheld-toolbar-item" href="account-wishlist.html"><span class="handheld-toolbar-icon"><i class="ci-heart"></i></span><span class="handheld-toolbar-label">Wishlist</span></a><a class="d-table-cell handheld-toolbar-item" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" onclick="window.scrollTo(0, 0)"><span class="handheld-toolbar-icon"><i class="ci-menu"></i></span><span class="handheld-toolbar-label">Menu</span></a><a class="d-table-cell handheld-toolbar-item" href="shop-cart.html"><span class="handheld-toolbar-icon"><i class="ci-cart"></i><span class="badge bg-primary rounded-pill ms-1">4</span></span><span class="handheld-toolbar-label">$265.00</span></a></div>
    </div>
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