<?php
require_once("php/already_signin.php");
if (!isLoggedIn()) {
  header("Location: account-signin.php");
  exit();
}
require_once("php/conn.php");
include_once('admin/php/products-view.php');

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

if($user['user_type'] != "Admin") {
  header("Location: home.php");
}

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

<body class="handheld-toolbar-enabled">
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
                  <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><img class="rounded-circle" src="<?php echo htmlspecialchars($user['avatar_img_link'])?>"></div>
                  <div class="ps-md-3">
                    <h3 class="fs-base mb-0"><?php echo htmlspecialchars($user['first_name']) ." ". htmlspecialchars($user['last_name'])?></h3><span class="text-accent fs-sm"><?php echo htmlspecialchars($user['email'])?></span><br><span class="text-dark fs-sm">Ngày đăng ký: <?php echo htmlspecialchars($user['created_at'])?></span>
                  </div>
                </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Menu</a>
              </div>
              <div class="d-lg-block collapse" id="account-menu">
                
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">Cài đặt tài khoản</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 " href="account-profile.php"><i class="ci-user opacity-60 me-2"></i>Thông tin tài khoản</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 " href="account-address.php"><i class="ci-location opacity-60 me-2"></i>Danh sách địa chỉ</a></li>
                  <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-payment.php"><i class="ci-card opacity-60 me-2"></i>Phương thức thanh toán</a></li>
                  <li class="d-lg-none border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="logout.php"><i class="ci-sign-out opacity-60 me-2"></i>Đăng xuất</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 " href="account-orders.php"><i class="ci-bag opacity-60 me-2"></i>Danh sách đơn hàng</a></li>
                </ul>
                <?php if ($user['user_type'] == 'Admin') {?>
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">Cài đặt quản trị</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 "
                      href="dashboard-categories.php"><i class="ci-view-list opacity-60 me-2"></i>Danh mục</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="dashboard-add-new-category.php"><i class="ci-add opacity-60 me-2"></i>Thêm danh mục</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active"
                      href="dashboard-products.php"><i class="ci-package opacity-60 me-2 active"></i>Sản phẩm</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="dashboard-add-new-product.php"><i class="ci-add opacity-60 me-2"></i>Thêm sản phẩm</a></li>
                <ul>
                <?php }?>
              </div>
            </div>
          </aside>
        <!-- Content-->
        <section class="col-lg-8 pt-lg-4 pb-4 mb-3 mt-5">
          <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
            <!-- Title-->
            <div class="d-sm-flex flex-wrap justify-content-between align-items-center border-bottom">
              <h2 class="h3 py-2 me-2 text-center text-sm-start">Your products</h2>
              <div class="py-2">
                <div class="d-flex flex-nowrap align-items-center pb-3">
                  <form method="get" class="d-flex justify-content-end mb-3">
                    <label for="sorting" class="form-label fw-normal text-nowrap mb-0 me-2">Sort by:</label>
                    <select class="form-select form-select-sm me-2" id="sorting" name="sort_by"
                      onchange="this.form.submit()">
                      <option value="p.price" <?= $sort_by == 'p.price' ? 'selected' : '' ?>>Price</option>
                      <option value="p.created_at" <?= $sort_by == 'p.created_at' ? 'selected' : '' ?>>Date Created
                      </option>
                      <option value="p.name" <?= $sort_by == 'p.name' ? 'selected' : '' ?>>Product Name
                      </option>
                    </select>
                    <input type="hidden" name="page" value="<?= $current_page ?>">
                  </form>
                </div>
              </div>
            </div>
            <!-- Product-->
            <?php
            if (!empty($products)): ?>
              <?php foreach ($products as $row): ?>
                <div class="d-block d-sm-flex align-items-center py-4 border-bottom">
                  <span class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">
                    <img class="rounded-3" src="<?= $row['image_url'] ?>" alt="Product">
                  </span>
                  <div class="text-center text-sm-start">
                    <h3 class="h6 product-title mb-2">
                      <?= htmlspecialchars($row['name']) ?>
                    </h3>
                    <div class="d-inline-block text-accent">
                      <?= number_format($row['price'] * 1000, 0, ',', '.') ?><small>đ</small>
                    </div>
                    <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2"> Ngày tạo: <?= $row['created_at'] ?>
                    </div>
                    <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                      <a href="dashboard-edit-product.php?product_id=<?= $row['product_id'] ?>"
                        class="btn bg-faded-info btn-icon me-2" data-bs-toggle="tooltip" title="Edit">
                        <i class="ci-edit text-info"></i>
                      </a>
                      <button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" title="Delete"
                        onclick="deleteProduct(<?= $row['product_id'] ?>)">
                        <i class="ci-trash text-danger"></i>
                      </button>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <?php
              // Hiển thị nút phân trang với giới hạn trang
              $total_pages = ceil($total_products / $products_per_page);
              $max_display_pages = 5; // Số lượng trang hiển thị tối đa (bao gồm trang hiện tại)

              if ($total_pages > 1) {
                echo '<nav aria-label="Page navigation" class="mt-5">';
                echo '<ul class="pagination justify-content-center">';

                // Nút "Previous"
                if ($current_page > 1) {
                  $prev_page = $current_page - 1;
                  echo "<li class='page-item'><a class='page-link' href='?page=$prev_page&sort_by=$sort_by' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                } else {
                  echo "<li class='page-item disabled'><span class='page-link' aria-hidden='true'>&laquo;</span></li>";
                }

                // Các trang
                $start_page = max(1, $current_page - floor($max_display_pages / 2));
                $end_page = min($total_pages, $start_page + $max_display_pages - 1);

                // Điều chỉnh lại $start_page nếu $end_page gần $total_pages
                if ($end_page - $start_page + 1 < $max_display_pages) {
                  $start_page = max(1, $end_page - $max_display_pages + 1);
                }

                // Hiển thị trang đầu tiên nếu cần
                if ($start_page > 1) {
                  echo "<li class='page-item'><a class='page-link' href='?page=1&sort_by=$sort_by'>1</a></li>";
                  if ($start_page > 2) {
                    echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                  }
                }

                // Hiển thị các trang ở giữa
                for ($i = $start_page; $i <= $end_page; $i++) {
                  $active_class = $i == $current_page ? "active" : "";
                  echo "<li class='page-item $active_class'><a class='page-link' href='?page=$i&sort_by=$sort_by'>$i</a></li>";
                }

                // Hiển thị trang cuối nếu cần
                if ($end_page < $total_pages) {
                  if ($end_page < $total_pages - 1) {
                    echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                  }
                  echo "<li class='page-item'><a class='page-link' href='?page=$total_pages&sort_by=$sort_by'>$total_pages</a></li>";
                }

                // Nút "Next"
                if ($current_page < $total_pages) {
                  $next_page = $current_page + 1;
                  echo "<li class='page-item'><a class='page-link' href='?page=$next_page&sort_by=$sort_by' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
                } else {
                  echo "<li class='page-item disabled'><span class='page-link' aria-hidden='true'>&raquo;</span></li>";
                }

                echo '</ul>';
                echo '</nav>';
              }
              ?>

            <?php else: ?>
              <p>Không có sản phẩm nào để hiển thị.</p>
            <?php endif; ?>
        </section>
      </div>
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
  <script src="admin/js/script.js"></script>
</body>

</html>