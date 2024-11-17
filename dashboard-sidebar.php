<!-- <script src="admin/js/myfunctions.js"></script> -->




<aside class="col-lg-4 pe-xl-5">
  <!-- Account menu toggler (hidden on screens larger 992px)-->
  <div class="d-block d-lg-none p-4"><a class="btn btn-outline-accent d-block" href="#account-menu"
      data-bs-toggle="collapse"><i class="ci-menu me-2"></i>Account menu</a></div>
  <!-- Actual menu-->
  <div class="h-100 border-end mb-2">
    <div class="d-lg-block collapse" id="account-menu">
      <div class="bg-secondary p-4">
        <h3 class="fs-sm mb-0 text-muted">Account</h3>
      </div>
      <ul class="list-unstyled mb-0">
        <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-settings.html"><i class="ci-settings opacity-60 me-2"></i>Settings</a></li>
        <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-purchases.html"><i class="ci-basket opacity-60 me-2"></i>Purchases</a></li>
        <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-favorites.html"><i class="ci-heart opacity-60 me-2"></i>Favorites<span
              class="fs-sm text-muted ms-auto">4</span></a></li>
      </ul>
      <div class="bg-secondary p-4">
        <h3 class="fs-sm mb-0 text-muted">Seller Dashboard</h3>
      </div>
      <ul class="list-unstyled mb-0">
        <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-sales.html"><i class="ci-dollar opacity-60 me-2"></i>Sales<span
              class="fs-sm text-muted ms-auto">$1,375.00</span></a></li>
        <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-categories.php"><i class="ci-package opacity-60 me-2"></i>Categories<span
              class="fs-sm text-muted ms-auto">5</span></a></li>
        <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-add-new-category.php"><i class="ci-cloud-upload opacity-60 me-2"></i>Add New
            Categories</a></li>
        <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3"
            href="dashboard-payouts.html"><i class="ci-currency-exchange opacity-60 me-2"></i>Payouts</a></li>
        <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-signin.html"><i
              class="ci-sign-out opacity-60 me-2"></i>Sign out</a></li>
      </ul>
      <hr>
    </div>
  </div>
</aside>

<script>
  const listItems = document.querySelectorAll(".list-unstyled li");

  listItems.forEach((item) => {
    item.addEventListener("click", function() {
      // Xóa class 'active' khỏi tất cả các thẻ li
      listItems.forEach((li) => li.classList.remove("active"));

      // Thêm class 'active' vào thẻ li được chọn
      this.classList.add("active");
    });
  });
</script>