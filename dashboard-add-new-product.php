<?php
include("admin/php/get-categories.php");
include("php/already_signin.php");
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

$categories = getCategories($conn);

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
  <style>
    .size-options {
      display: none;
    }
  </style>
</head>
<!-- Body-->

<body class="handheld-toolbar-enabled">
  <main class="page-wrapper">
    <div id="header"></div>
    <!-- Dashboard header-->
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
      <div class="bg-light shadow-lg rounded-3 overflow-hidden">
        <div class="row">
          <!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
            <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
              <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
                <div class="d-md-flex align-items-center">
                  <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0"
                    style="width: 6.375rem;"><span class="badge bg-warning position-absolute end-0 mt-n2"
                      data-bs-toggle="tooltip" title="Reward points">384</span><img class="rounded-circle"
                      src="<?php echo htmlspecialchars($user['avatar_img_link']) ?>"></div>
                  <div class="ps-md-3">
                    <h3 class="fs-base mb-0">
                      <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) ?>
                    </h3>
                    <span class="text-accent fs-sm"><?php echo htmlspecialchars($user['email']) ?></span>
                  </div>
                </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu"
                  data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Menu</a>
              </div>
              <div class="d-lg-block collapse" id="account-menu">
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">Cài đặt tài khoản</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="account-profile.html"><i class="ci-user opacity-60 me-2"></i>Thông tin tài khoản</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="account-address.html"><i class="ci-location opacity-60 me-2"></i>Danh sách địa chỉ</a></li>
                  <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="account-payment.html"><i class="ci-card opacity-60 me-2"></i>Phương thức thanh toán</a></li>
                  <li class="d-lg-none border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
                      href="account-signin.html"><i class="ci-sign-out opacity-60 me-2"></i>Đăng xuất</a></li>
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
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active"
                      href="dashboard-add-new-category.php"><i class="ci-add opacity-60 me-2"></i>Thêm sản phẩm</a></li>
              </div>
            </div>
          </aside>

          <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
            <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
              <!-- Title-->
              <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
                <h2 class="h3 py-2 me-2 text-center text-sm-start">Thêm Sản Phẩm</h2>
              </div>
              <form action="admin/php/addProduct.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3 pb-2">
                  <label class="form-label" for="product-name">Tên sản phẩm</label>
                  <input class="form-control" type="text" name="product-name" id="product-name">
                </div>
                <div class="mb-3 pb-2">
                  <div class="py-2">
                    <label class="form-label" for="category">Danh mục</label>
                    <select class="form-select me-2" id="category" name="category">
                      <option value="">Chọn danh mục</option>
                      <?php
                      // Hiển thị danh mục phân cấp
                      displayCategoryOptions($categories);
                      ?>
                    </select>
                  </div>
                </div>
                <div class="mb-3 pb-2">
                  <label class="form-label" for="sizeType">Kích thước</label>
                  <select id="sizeType" class="form-control" name="sizeType">
                    <option selected>Chọn loại kích thước</option>
                    <option value="none">Không có</option>
                    <option value="letter">Theo chữ</option>
                    <option value="number">Theo số</option>
                  </select>
                </div>

                <!-- Input số lượng khi không có size -->
                <div id="noSize" class="size-options">
                  <label class="form-label">Tổng số lượng:</label>
                  <div class="input-group mb-2" style="max-width: 200px;">
                    <span class="input-group-text">SL</span>
                    <input type="number" class="form-control" name="total_quantity" min="0" value="0">
                  </div>
                </div>

                <!-- Kích thước theo chữ -->
                <div id="letterSizes" class="size-options">
                  <label class="form-label">Kích thước theo chữ:</label>
                  <div class="row">
                    <div class="col-6 col-md-4 mb-2">
                      <div class="input-group">
                        <span class="input-group-text">XS</span>
                        <input type="number" class="form-control" name="size[XS]" min="0" value="0">
                      </div>
                    </div>
                    <div class="col-6 col-md-4 mb-2">
                      <div class="input-group">
                        <span class="input-group-text">S</span>
                        <input type="number" class="form-control" name="size[S]" min="0" value="0">
                      </div>
                    </div>
                    <div class="col-6 col-md-4 mb-2">
                      <div class="input-group">
                        <span class="input-group-text">M</span>
                        <input type="number" class="form-control" name="size[M]" min="0" value="0">
                      </div>
                    </div>
                    <div class="col-6 col-md-4 mb-2">
                      <div class="input-group">
                        <span class="input-group-text">L</span>
                        <input type="number" class="form-control" name="size[L]" min="0" value="0">
                      </div>
                    </div>
                    <div class="col-6 col-md-4 mb-2">
                      <div class="input-group">
                        <span class="input-group-text">XL</span>
                        <input type="number" class="form-control" name="size[XL]" min="0" value="0">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Kích thước theo số -->
                <div id="numberSizes" class="size-options">
                  <label class="form-label">Kích thước theo số:</label>
                  <div class="row">
                    <!-- Tạo các checkbox số từ 39 đến 50 -->
                    <script>
                      for (let i = 39; i <= 50; i++) {
                        document.write(`
                        <div class="col-6 col-md-4 mb-2">
                          <div class="input-group">
                            <span class="input-group-text">${i}</span>
                            <input type="number" class="form-control" name="size[${i}]" min="0" value="0">
                          </div>
                        </div>
                      `);
                      }
                    </script>
                  </div>
                </div>
                <script>
                  document.querySelectorAll('.size-options').forEach(el => {
                    el.classList.add('mb-3', 'pb-2');
                  });
                  document.getElementById('sizeType').addEventListener('change', function() {
                    const value = this.value;
                    document.querySelectorAll('.size-options').forEach(el => el.style.display = 'none');

                    if (value === 'none') {
                      document.getElementById('noSize').style.display = 'block';
                    } else if (value === 'letter') {
                      document.getElementById('letterSizes').style.display = 'block';
                    } else if (value === 'number') {
                      document.getElementById('numberSizes').style.display = 'block';
                    }
                  });
                </script>
                <div class="file-drop-area mb-3">
                  <div class="file-drop-icon ci-cloud-upload"></div>
                  <span class="file-drop-message">Drag and drop here to upload product screenshots</span>
                  <input class="file-drop-input" name="product-images[]" type="file" multiple>
                  <button class="file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select files</button>
                  <div class="form-text">1000 x 800px ideal size for hi-res displays</div>
                </div>

                <div id="file-list" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                <script>
                  const fileInput = document.querySelector('.file-drop-input');
                  const fileListDisplay = document.getElementById('file-list');

                  fileInput.addEventListener('change', () => {
                    fileListDisplay.innerHTML = ''; // Xóa danh sách ảnh cũ
                    fileInput.innerHTML = ''; // Xóa danh sách ảnh cũ
                    Array.from(fileInput.files).forEach(file => {
                      if (file.type.startsWith('image/')) { // Kiểm tra xem tệp có phải là ảnh không
                        const reader = new FileReader();
                        reader.onload = (e) => {
                          const img = document.createElement('img');
                          img.src = e.target.result;
                          img.style.width = '100px'; // Kích thước hiển thị của ảnh
                          img.style.height = 'auto';
                          fileListDisplay.appendChild(img); // Hiển thị ảnh đã chọn
                        };
                        reader.readAsDataURL(file); // Đọc tệp ảnh
                      }
                    });
                  });
                </script>
                <div class="mb-3 py-2">
                  <label class="form-label" for="description">Mô tả</label>
                  <textarea class="form-control" rows="6" name="description" id="description"></textarea>
                  <div class="bg-secondary p-3 fs-ms rounded-bottom"><span
                      class="d-inline-block fw-medium me-2 my-1">Markdown supported:</span><em
                      class="d-inline-block border-end pe-2 me-2 my-1">*Italic*</em><strong
                      class="d-inline-block border-end pe-2 me-2 my-1">**Bold**</strong><span
                      class="d-inline-block border-end pe-2 me-2 my-1">- List item</span><span
                      class="d-inline-block border-end pe-2 me-2 my-1">##Heading##</span><span
                      class="d-inline-block">--- Horizontal rule</span></div>
                </div>
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label class="form-label" for="price">Giá</label>
                    <div class="input-group">
                      <input class="form-control" type="text" name="price" id="price">
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary d-block w-100" name="addProduct" type="submit"><i
                    class="ci-cloud-upload fs-lg me-2"></i>Thêm</button>
              </form>
            </div>
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
</body>

</html>