<?php
  require_once("php/already_signin.php");
  if (isLoggedIn()) {
    header("Location: test.php");
    exit();
  }
?>

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
   
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!-- Main theme script-->
    <script src="js/theme.min.js"></script>
  </body>
</html>