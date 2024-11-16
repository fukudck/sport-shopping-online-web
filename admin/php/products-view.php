<?php
include_once  'category_functions.php';
include_once 'php/conn.php';

$sql = "SELECT products.name, products.price, products.created_at, images.image_url
        FROM products
        JOIN (
            SELECT product_id, MIN(image_url) AS image_url
            FROM product_images
            GROUP BY product_id
        ) AS images ON products.product_id = images.product_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '  <div class="d-block d-sm-flex align-items-center py-4 border-bottom"><a
                class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="marketplace-single.html"
                style="width: 12.5rem;"><img class="rounded-3" src="' . $row['image_url'] . '"
                  alt="Product"></a>
              <div class="text-center text-sm-start">
                <h3 class="h6 product-title mb-2"><a href="marketplace-single.html">' . $row['name'] . '</a>
                </h3>
                <div class="d-inline-block text-accent">' . $row['price'] . '<small>đ</small></div>
                <div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2"> Ngày tạo: ' . $row['created_at'] . '</div>
                <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                  <button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip"
                    aria-label="Edit" data-bs-original-title="Edit"><i class="ci-edit text-info"></i></button>
                  <button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip"
                    aria-label="Delete" data-bs-original-title="Delete"><i class="ci-trash text-danger"></i></button>
                </div>
              </div>
            </div>';
  }
}
