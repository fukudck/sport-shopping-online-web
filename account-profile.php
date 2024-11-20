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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $first_name = htmlspecialchars($_POST['first_name']);
  $last_name = htmlspecialchars($_POST['last_name']);
  $phone_number = htmlspecialchars($_POST['phone_number']);
  $new_password = !empty($_POST['new_password']) ? $_POST['new_password'] : null;


  updateUser($conn, $user_id, $first_name, $last_name, $phone_number, $new_password);
}
// Đóng kết nối
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
  <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css" />
  <link rel="stylesheet" media="screen" href="vendor/tiny-slider/dist/tiny-slider.css" />
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
              <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Trang
                  chủ</a></li>
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
                <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0"
                  style="width: 6.375rem;"><img class="rounded-circle"
                    src="<?php echo htmlspecialchars($user['avatar_img_link']) ?>"></div>
                <div class="ps-md-3">
                  <h3 class="fs-base mb-0">
                    <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) ?>
                  </h3>
                  <span class="text-accent fs-sm"><?php echo htmlspecialchars($user['email']) ?></span><br><span
                    class="text-dark fs-sm">Ngày đăng ký: <?php echo htmlspecialchars($user['created_at']) ?></span>
                </div>
              </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu"
                data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Menu</a>
            </div>
            <div class="d-lg-block collapse" id="account-menu">
              <div class="bg-secondary px-4 py-3">
                <h3 class="fs-sm mb-0 text-muted">Cài đặt tài khoản</h3>
              </div>
              <ul class="list-unstyled mb-0">
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active"
                    href="account-profile.php"><i class="ci-user opacity-60 me-2"></i>Thông tin tài khoản</a></li>
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                    href="account-address.php"><i class="ci-location opacity-60 me-2"></i>Danh sách địa chỉ</a></li>
                <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                    href="account-payment.php"><i class="ci-card opacity-60 me-2"></i>Phương thức thanh toán</a></li>
                <li class="d-lg-none border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                    href="logout.php"><i class="ci-sign-out opacity-60 me-2"></i>Đăng xuất</a></li>
              </ul>
              <div class="bg-secondary px-4 py-3">
                <h3 class="fs-sm mb-0 text-muted">Cài đặt quản trị</h3>
              </div>
              <ul class="list-unstyled mb-0">
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 "
                    href="dashboard-categories.php"><i class="ci-view-list opacity-60 me-2"></i>Danh mục</a></li>
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 "
                    href="dashboard-add-new-category.php"><i class="ci-add opacity-60 me-2"></i>Thêm danh mục</a></li>
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 "
                    href="dashboard-products.php"><i class="ci-package opacity-60 me-2"></i>Sản phẩm</a></li>
                <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                    href="dashboard-add-new-product.php"><i class="ci-add opacity-60 me-2"></i>Thêm sản phẩm</a></li>
            </div>
          </div>
        </aside>
        <!-- Content  -->
        <section class="col-lg-8">
          <!-- Toolbar-->
          <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
            <h6 class="fs-base text-light mb-0">Cập nhật thông tin cá nhân bên dưới:</h6><a
              class="btn btn-primary btn-sm" href="logout.php"><i class="ci-sign-out me-2"></i>Đăng xuất</a>
          </div>
          <!-- Profile form-->
          <form class="needs-validation" novalidate method="post">
            <div class="bg-secondary rounded-3 p-4 mb-4">
              <div class="d-flex align-items-center"><img class="rounded"
                  src="<?php echo htmlspecialchars($user['avatar_img_link']) ?>" width="90">
                <div class="ps-3">
                  <button class="btn btn-light btn-shadow btn-sm mb-2" type="button"><i class="ci-loading me-2"></i>Thay
                    ảnh</button>
                  <div class="p mb-0 fs-ms text-muted">Tải lên hình ảnh JPG, GIF hoặc PNG. Yêu cầu kích thước 300 x 300.
                  </div>
                </div>
              </div>
            </div>
            <div class="row gx-4 gy-3">
              <div class="col-sm-6">
                <label class="form-label" for="account-fn">Họ và tên đệm</label>
                <input required name="first_name" class="form-control" type="text" id="account-fn"
                  value="<?php echo htmlspecialchars($user['first_name']) ?>">
                <div class="invalid-feedback">Vui lòng nhập họ và tên đệm!</div>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="account-ln">Tên</label>
                <input required name="last_name" class="form-control" type="text" id="account-ln"
                  value="<?php echo htmlspecialchars($user['last_name']) ?>">
                <div class="invalid-feedback">Vui lòng nhập tên!</div>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="account-email">Địa chỉ Email</label>
                <input class="form-control" type="email" id="account-email"
                  value="<?php echo htmlspecialchars($user['email']) ?>" disabled>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="account-phone">Số điện thoại</label>
                <input class="form-control" name="phone_number" type="text" id="account-phone"
                  value="<?php echo htmlspecialchars($user['phone_number']) ?>" required>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="account-pass">Mật khẩu mới</label>
                <div class="password-toggle">
                  <input class="form-control" name="new_password" type="password" id="account-pass">
                  <label class="password-toggle-btn" aria-label="Show/hide password">
                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                  </label>
                </div>
              </div>
              <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="text-end">
                  <button class="btn btn-primary mt-3 mt-sm-0" type="submit">Cập nhật</button>
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
  <!-- Quay ve dau trang--><a class="btn-scroll-top" href="#top" data-scroll><span
      class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up">
    </i></a>
  <!-- Vendor scrits: js libraries and plugins-->
  <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/simplebar/dist/simplebar.min.js"></script>
  <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
  <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
  <!-- Main theme script-->
  <script src="js/theme.min.js"></script>
  <script>
    document.getElementById('password-form').addEventListener('submit', function(event) {
      const password = document.getElementById('account-pass').value;
      const confirmPassword = document.getElementById('account-confirm-pass').value;
      const errorMessage = document.getElementById('error-message');

      // Kiểm tra mật khẩu
      if (password !== confirmPassword) {
        event.preventDefault(); // Ngăn form gửi đi
        errorMessage.style.display = 'block'; // Hiển thị thông báo lỗi
      } else {
        errorMessage.style.display = 'none'; // Ẩn thông báo lỗi nếu khớp
      }
    });
  </script>
</body>

</html>