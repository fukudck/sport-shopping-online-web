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
  $orders = getOrders($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>Quản lí đơn hàng</title>
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
                <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Trang chủ</a></li>
                <li class="breadcrumb-item text-nowrap"><a href="#">Tài khoản</a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Đơn hàng</li>
              </ol>
            </nav>
          </div>
          <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Đơn hàng của tôi</h1>
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
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="account-orders.php"><i class="ci-bag opacity-60 me-2"></i>Danh sách đơn hàng</a></li>
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
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="dashboard-products.php"><i class="ci-package opacity-60 me-2"></i>Sản phẩm</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="dashboard-add-new-product.php"><i class="ci-add opacity-60 me-2"></i>Thêm sản phẩm</a></li>
                <ul>
                <?php }?>
              </div>
            </div>
          </aside>
          <!-- Content  -->
          <section class="col-lg-8">
            <!-- Toolbar-->
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
              <h6 class="fs-base text-light mb-0">Danh sách đơn hàng:</h6><a class="btn btn-primary btn-sm" href="logout.php"><i class="ci-sign-out me-2"></i>Đăng xuất</a>
            </div>
            <!-- Orders list-->
            <div class="table-responsive fs-md mb-4">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th></th>
                    <th>Tổng cộng</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    foreach ($orders as $order) {
                    
                    ?>
                  <tr>
                    <td class="py-3"><a class="nav-link-style fw-medium fs-sm" data-bs-toggle="modal"><?php echo $order['order_id']?></a></td>
                    <td class="py-3"><?php echo $order['created_at']?></td>
                    <td class="py-3">
                      <?php switch($order['order_status']) {
                        case "Pending":
                          echo '<span class="badge bg-info m-0">Đang chuẩn bị</span>';
                          break;
                        case "Delivered":
                          echo '<span class="badge bg-success m-0">Đã giao</span>';
                          break;
                        case "Cancelled":
                          echo '<span class="badge bg-danger m-0">Đã huỷ</span>';
                          break;
                        case "Shipped":
                          echo '<span class="badge bg-info m-0">Đang giao</span>';
                          break;
                        
                        
                    
                      }?>
                    </td>
                    <td class="py-3"><?php echo $order['total_amount']?>0 VNĐ</td>
                  </tr>
                  
                  <?php } ?>
                </tbody>
              </table>
            </div>
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
    <!-- Quay ve dau trang--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!--diaphuong script-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="js/diaphuong.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
  </body>
</html>