<?php
require_once('php/conn.php');
require('php/query_func.php');
$product_per_page = 15;
// Lấy số trang hiện tại từ URL (mặc định là trang 1 nếu không có)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);

$sort_by_price = "p.product_id";

if (isset($_GET['price'])) {
  switch ($_GET['price']) {
    case "asc":
      $sort_by_price = "p.price ASC";
      break;
    case "desc":
      $sort_by_price = "p.price DESC";
      break;
    default:
      $sort_by_price = "p.product_id";
  }
}

$category_id = null;
if (isset($_GET['category_id'])) {
  $category_id = $_GET['category_id'];
}

$products = getProductList($conn, $sort_by_price, $category_id, $page, $product_per_page )['pC'];

$total_products = getProductList($conn, $sort_by_price, $category_id, $page )['total_product'];

$total_pages = ceil($total_products / 15);

$categories = getCategoryList($conn)['categories'];
$sub_categories = getCategoryList($conn)['sub_categories'];

?>



<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="utf-8" />
  <title>Danh Sách Sản Phẩm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Favicon and Touch Icons-->
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
  <link rel="manifest" href="site.webmanifest" />
  <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="theme-color" content="#ffffff" />
  <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
  <link
    rel="stylesheet"
    media="screen"
    href="vendor/simplebar/dist/simplebar.min.css" />
  <link
    rel="stylesheet"
    media="screen"
    href="vendor/tiny-slider/dist/tiny-slider.css" />
  <link
    rel="stylesheet"
    media="screen"
    href="vendor/nouislider/dist/nouislider.min.css" />
  <link
    rel="stylesheet"
    media="screen"
    href="vendor/drift-zoom/dist/drift-basic.min.css" />
  <!-- Main Theme Styles + Bootstrap-->
  <link rel="stylesheet" media="screen" href="css/theme.min.css" />


</head>
<!-- Body-->

<body>
  <main class="page-wrapper">
    <div id="header"></div>
    <div class="page-title-overlap bg-dark pt-4">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
              <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Trang chủ</a></li>
              <li class="breadcrumb-item text-nowrap"><a href="#">Sản phẩm</a>
              </li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
          <h1 class="h3 text-light mb-0">Danh sách sản phẩm</h1>
        </div>
      </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
      <div class="row">
        <!-- Content  -->
        <section class="col-lg-8">
          <!-- Toolbar-->
          <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
            <div class="d-flex flex-wrap">
              <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                <label class="text-light fs-sm opacity-75 text-nowrap me-2 d-none d-sm-block" for="sorting">Sắp xếp theo:</label>
                <select class="form-select" id="sorting" onchange="handleSortingChange()">
                  <option>Mặc định</option>
                  <option value="asc" <?php echo isset($_GET['price']) && $_GET['price'] === 'asc' ? 'selected' : ''; ?>>Giá: Thấp đến Cao</option>
                  <option value="desc" <?php echo isset($_GET['price']) && $_GET['price'] === 'desc' ? 'selected' : ''; ?>>Giá: Cao đến Thấp</option>

                </select>
              </div>
            </div>


          </div>
          <!-- Products grid-->
          <div class="row mx-n2">
            <?php foreach ($products as $product) { ?>
              <!-- Product-->
              <div class="col-md-4 col-sm-6 px-2 mb-4">
                <div class="card card-product card_container h-100">
                  <a href="product_detail.php?&product_id=<?php echo $product['product_id'] ?>" class="card-img-top">
                    <img class="image_product img-fluid" src="<?php echo $product['image_url'] ?>" alt="Product">
                  </a>
                  <div class="card-body py-2">
                    <a class="product-meta d-block fs-xs pb-1"><?php echo $product['category_name'] ?></a>
                    <h3 class="product-title fs-sm">
                      <a href="product_detail.php?&product_id=<?php echo $product['product_id'] ?>">
                        <?php echo $product['name'] ?>
                      </a>
                    </h3>
                    <div class="d-flex justify-content-between">
                      <div class="product-price">
                        <span class="text-accent">
                          <?php echo (int)$product['price'] ?><small>.000<sup>đ</sup></small>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END- Product-->
            <?php } ?>
          </div>


          <hr class="my-3">
          <!-- Pagination-->
          <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" onclick="updateURL('page', 1, url)"><i class="ci-arrow-left me-2"></i>Trang đầu</a></li>
            </ul>
            <ul class="pagination">

              <?php
              $startPage = max(1, $page - floor(5 / 2));
              $endPage = min($total_pages, $startPage + 5 - 1);
              for ($i = $startPage; $i <= $endPage; $i++) {
              ?>
                <li class="page-item <?php if ($page == $i) echo "active" ?> d-none d-sm-block"><a onclick="updateURL('page', <?php echo $i ?>, url)" class="page-link"><?php echo $i ?></a></li>
              <?php } ?>
            </ul>
            <ul class="pagination">
              <li class="page-item"><a class="page-link" onclick="updateURL('page', <?php echo $total_pages ?>, url)" aria-label="Next">Trang cuối<i class="ci-arrow-right ms-2"></i></a></li>
            </ul>
          </nav>


        </section>
        <!-- Sidebar-->
        <aside class="col-lg-4">
          <!-- Sidebar-->
          <div
            class="offcanvas offcanvas-collapse offcanvas-end bg-white w-100 rounded-3 shadow-lg ms-lg-auto py-1"
            id="shop-sidebar"
            style="max-width: 22rem">
            <div class="offcanvas-body py-grid-gutter px-lg-grid-gutter">
              <!-- Categories-->
              <div class="widget widget-categories mb-4 pb-4 border-bottom">
                <h3 class="widget-title">
                  <span class="badge bg-primary badge-shadow">Thể loại</span>
                </h3>
                <div class="accordion mt-n1" id="shop-categories">

                  <?php foreach ($categories as $category) { ?>
                    <!-- Category -->
                    <div class="accordion-item">
                      <h3 class="accordion-header">
                        <a
                          class="accordion-button collapsed"
                          href="#category_id_<?php echo $category['category_id'] ?>"
                          role="button"
                          data-bs-toggle="collapse"
                          aria-expanded="false"
                          aria-controls="<?php echo $category['category_id'] ?>"><?php echo $category['category_name']  ?></a>
                      </h3>
                      <div
                        class="accordion-collapse collapse"
                        id="category_id_<?php echo $category['category_id'] ?>"
                        data-bs-parent="#shop-categories">
                        <div class="accordion-body">
                          <div class="widget widget-links widget-filter">
                            <div class="input-group input-group-sm mb-2">
                              <input
                                class="widget-filter-search form-control rounded-end"
                                type="text"
                                placeholder="Tìm kiếm" />
                              <i
                                class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                            </div>
                            <ul
                              class="widget-list widget-filter-list pt-1"
                              style="height: 5rem"
                              data-simplebar
                              data-simplebar-auto-hide="false">
                              <?php foreach ($sub_categories as $sub_category) {
                                if ($sub_category['parent_category_id'] != $category['category_id']) {
                                  continue;
                                }
                              ?>
                                <li class="widget-list-item widget-filter-item">
                                  <a
                                    class="widget-list-link d-flex justify-content-between align-items-center"
                                    onclick="updateURL('category_id', <?php echo $sub_category['category_id'] ?>, url)">
                                    <span class="widget-filter-item-text"><?php echo $sub_category['category_name'] ?></span>
                                  </a>
                                </li>
                              <?php } ?>

                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <!-- End-Category -->

                </div>
              </div>
              <!-- Size -->

              <!-- Size -->
            </div>
          </div>
        </aside>
      </div>
    </div>
  </main>
  <div id="footer"></div>
  <!-- Back To Top Button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up"> </i></a>
  <script>
    async function loadComponent(id, file) {
      const response = await fetch(file);
      const html = await response.text();
      document.getElementById(id).innerHTML = html;
    }

    loadComponent("header", "header.html");
    loadComponent("footer", "footer.html");
  </script>
  <script>
    const url = new URL(window.location.href);

    function handleSortingChange() {
      const sorting = document.getElementById("sorting").value;
      url.searchParams.delete("page"); // Xóa tham số 'page'

      if (sorting === "asc" || sorting === "desc") {
        updateURL("price", sorting, url);

      } else {
        url.searchParams.delete("price");
        window.location.href = url.toString();
      }
    }
    

    function updateURL(param, value, url) {
      // Lấy URL hiện tại nếu chưa có URL được truyền vào
      if (url == 'undefined') {
        url = new URL(window.location.href);
      }

      // Kiểm tra nếu param không phải là "page"
      if (param !== 'page') {
        // Nếu có tham số "page" thì xóa nó
        url.searchParams.delete('page');
      }

      // Cập nhật hoặc thêm biến GET
      url.searchParams.set(param, value);

      // Chuyển hướng đến URL mới
      window.location.href = url.toString();
    }
  </script>

  <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/simplebar/dist/simplebar.min.js"></script>
  <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
  <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
  <script src="vendor/nouislider/dist/nouislider.min.js"></script>
  <script src="vendor/drift-zoom/dist/Drift.min.js"></script>
  <script src="js/theme.min.js"></script>
</body>

</html>