<!DOCTYPE html>
<html lang="en">
  
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title> Đăng nhập tài khoản</title>

    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="css/theme.min.css">
  </head>
  <!-- Body-->
  <body>
    <main class="page-wrapper">     
      <!-- Navbar 3 Level (Light)-->
      <header class="shadow-sm">
        <div class="navbar-sticky bg-light ">
          <div class="navbar navbar-expand-lg navbar-light inner_header">
            <div class="container"><a
                class="navbar-brand d-none d-sm-block flex-shrink-0"
                href="index-2.html"><img src="img/logo-dark.png" width="142"
                  alt="Cartzilla"></a><a
                class="navbar-brand d-sm-none flex-shrink-0 me-2"
                href="index-2.html"><img src="img/logo-icon.png" width="74"
                  alt="Cartzilla"></a>
              <div class="d-lg-flex">
                <ul class="navbar-nav flex">
                  <li class="nav-item"><a class="nav-link" href="#">Trang
                      chủ</a>
                  </li>
                  <li class="nav-item"><a class="nav-link" href="#">Sản phẩm</a>
                  </li>
                  <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a>
                  </li>
                </ul>
              </div>
              <div
                class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                <a class="navbar-tool d-none d-lg-flex"
                  href="account-signin.html"><span
                    class="navbar-tool-tooltip">Tài khoản</span>
                  <div class="navbar-tool-icon-box"><i
                      class="navbar-tool-icon ci-user"></i></div>
                <div class="navbar-tool dropdown ms-3"><a
                    class="navbar-tool-icon-box bg-secondary dropdown-toggle"
                    href="shop-cart.html"><span
                      class="navbar-tool-label">4</span><i
                      class="navbar-tool-icon ci-cart"></i></a><a
                    class="navbar-tool-text" href="shop-cart.html"><small>My
                      Cart</small>$265.00</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header> 


      <div class="container py-4 py-lg-5 my-4">
        <div class="row">
          <div class="col-md-6">
            <div class="card border-0 shadow">
              <div class="card-body">
                <h2 class="h4 mb-1">Đăng nhập</h2>
                <div class="py-3">
                  <h3 class="d-inline-block align-middle fs-base fw-medium mb-2 me-2">Đăng nhập với:</h3>
                  <div class="d-inline-block align-middle"><a class="btn-social bs-google me-2 mb-2" href="#" data-bs-toggle="tooltip" title="Sign in with Google"><i class="ci-google"></i></a><a class="btn-social bs-facebook me-2 mb-2" href="#" data-bs-toggle="tooltip" title="Sign in with Facebook"><i class="ci-facebook"></i></a><a class="btn-social bs-twitter me-2 mb-2" href="#" data-bs-toggle="tooltip" title="Sign in with Twitter"><i class="ci-twitter"></i></a></div>
                </div>
                <hr>
                <h3 class="fs-base pt-3 pb-2">Hoặc đăng nhập bằng Email</h3>


                <form class="needs-validation" novalidate method="post" action="php/signin_process.php">
                  <div class="input-group mb-3"><i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" type="email" placeholder="Email của bạn" required name="email">
                  </div>
                  <div class="input-group mb-3"><i class="ci-locked position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                    <div class="password-toggle w-100">
                      <input class="form-control" type="password" placeholder="Password" required name="password">
                      <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                      </label>
                    </div>
                  </div>


                  <div class="alert alert-danger alert-dismissible fade show" role="alert" <?php if (!isset($_GET['error_code']) || $_GET['error_code'] != 1) echo 'hidden'; ?>>
                    <span class="fw-medium">Lỗi:</span> Sai thông tin đăng nhập.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>

                  <div class="d-flex flex-wrap justify-content-between">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" checked id="remember_me" name="remember_me">
                      <label class="form-check-label" for="remember_me">Nhớ mật khẩu</label>
                    </div>
                  </div>
                  <hr class="mt-4">
                  <div class="text-end pt-4">
                    <button class="btn btn-primary" type="submit"><i class="ci-sign-in me-2 ms-n21"></i>Đăng nhập</button>
                  </div>
                </form>


              </div>
            </div>
          </div>

          <div class="col-md-6  ">
            <div class="card border-0 shadow">
              <div class="card-body">
                <h2 class="h4 mb-3">Chưa có tài khoản? Đăng ký</h2>
                <p class="fs-sm text-muted mb-4">Việc đăng ký mất chưa đầy một phút nhưng giúp bạn kiểm soát hoàn toàn đơn hàng của mình.</p>

                <form class="needs-validation" novalidate method="post" action="php/signup_process.php">
                  <div class="row gx-4 gy-3">
                    <div class="col-sm-6">
                      <label class="form-label" for="reg-fn">Họ và tên đệm</label>
                      <input class="form-control" type="text" required id="reg-fn" name="first_name">
                      <div class="invalid-feedback">Vui lòng nhập họ và tên đệm!</div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="reg-ln">Tên</label>
                      <input class="form-control" type="text" required id="reg-ln" name="last_name">
                      <div class="invalid-feedback">Vui lòng nhập tên!</div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="reg-email">Địa chỉ E-mail</label>
                      <input class="form-control" type="email" required id="reg-email" name="email">
                      <div class="invalid-feedback">Vui lòng nhập địa chỉ email!</div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="reg-phone">Số điện thoại</label>
                      <input class="form-control" type="text" required id="reg-phone" name="phone">
                      <div class="invalid-feedback">Vui lòng nhập số điện thoại!</div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="reg-password">Mật Khẩu</label>
                      <input class="form-control" type="password" required id="reg-password" name="password">
                      <div class="invalid-feedback">Vui lòng nhập mật khẩu!</div>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label" for="reg-password-confirm">Nhập lại mật khẩu</label>
                      <input class="form-control" type="password" required id="reg-password-confirm" name="password_confirm">
                      <div class="invalid-feedback">Mật khẩu không trùng khớp!</div>
                    </div>

                    <div class="alert alert-danger alert-dismissible fade show" role="alert" <?php if (!isset($_GET['error_code']) || $_GET['error_code'] != 2) echo 'hidden'; ?>>
                      <span class="fw-medium">Lỗi:</span> Email này đã được dùng.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="col-12 text-end">
                      <button class="btn btn-primary" type="submit"><i class="ci-user me-2 ms-n1"></i>Đăng ký</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Footer-->
    <footer class="footer bg-dark pt-5">
      <div class="container">
        <div class="row pb-2">
          <div class="col-md-4 col-sm-6">
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-light">Shop departments</h3>
              <ul class="widget-list">
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Dụng cụ</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Giày</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Áo</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Quần áo</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Đồ bơi</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Clogs &amp; Mules</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Thiết bị</li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Phụ kiện</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Kính mát &amp; Eyewear</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Đồng hồ</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-light">Account &amp; shipping
                info</h3>
              <ul class="widget-list">
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Hỗ trợ khách hàng</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Chọn Size Giày Đá Bóng</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Giao hàng tận nơi</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Bảo hành & đổi trả</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Khách hàng thân thiết</a></li>
              </ul>
            </div>
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-light">About us</h3>
              <ul class="widget-list">
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Về chúng tôi</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Our team</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">Careers</a></li>
                <li class="widget-list-item"><a class="widget-list-link"
                    href="#">News</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget pb-2 mb-4">
              <h3 class="widget-title text-light pb-1">Stay informed</h3>
              <form class="subscription-form validate"
                action="https://studio.us12.list-manage.com/subscribe/post?u=c7103e2c981361a6639545bd5&amp;amp;id=29ca296126"
                method="post" name="mc-embedded-subscribe-form"
                target="_blank" novalidate>
                <div class="input-group flex-nowrap"><i
                    class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                  <input class="form-control rounded-start" type="email"
                    name="EMAIL" placeholder="Your email" required>
                    <button class="btn btn-primary" type="submit"
                    name="subscribe">Đăng ký*</button>
                </div>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;"
                  aria-hidden="true">
                  <input class="subscription-form-antispam" type="text"
                    name="b_c7103e2c981361a6639545bd5_29ca296126"
                    tabindex="-1">
                </div>
                <div class="subscription-status"></div>
              </form>
            </div>
            <div class="widget pb-2 mb-4">
            <h3 class="widget-title text-light pb-1">Download our app</h3>
              <div class="d-flex flex-wrap">
                <div class="me-2 mb-2"><a class="btn-market btn-apple"
                    href="#" role="button"><span
                      class="btn-market-subtitle">Download on the</span><span
                      class="btn-market-title">App Store</span></a></div>
                <div class="mb-2"><a class="btn-market btn-google" href="#"
                    role="button"><span class="btn-market-subtitle">Download
                      on the</span><span class="btn-market-title">Google
                      Play</span></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
   
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
  </body>
</html>