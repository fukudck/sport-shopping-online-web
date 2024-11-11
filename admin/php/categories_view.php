<?php
include_once  'category_functions.php';
include_once 'php/conn.php';
// require 'admin/php/category_functions.php';

$categories = getCategoriesIntoIndex($conn);

if (count($categories) > 0) {
  foreach ($categories as $category) {
    echo '<div class="d-block d-sm-flex align-items-center py-4 border-bottom">';

    echo '<span class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto"  style="width: 12.5rem;">';
    echo '<img class="rounded-3" src=' . $category['category_image_url'] . ' alt="">';
    echo '</span>';

    echo '<div class="text-center text-sm-start">';

    echo '<h3 class="h6 product-title mb-2"><span>' . $category['category_name'] . '</span></h3>';

    echo '<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Parent Category: <span class="fw-medium">' . getParentCategoryName($category['parent_category_id'], $conn) . '</span></div>';

    echo '<div class="d-flex justify-content-center justify-content-sm-start pt-3">';
    echo '<button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit text-info"></i></button>';
    echo '<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" title="Delete"><i class="ci-trash text-danger"></i></button>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
  }
} else {
  echo "Không có danh mục nào";
}

// Đóng kết nối
$conn->close();
