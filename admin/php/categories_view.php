<?php
include  'category_functions.php';
include 'php/conn.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
$categories_per_page = 7; // Số danh mục mỗi trang

$category_data = getCategoriesIntoIndex($conn, $page, $categories_per_page);

function printCategories($categories, $conn)
{
  if (count($categories) > 0) {
    foreach ($categories as $category) {
      echo '<div class="d-block d-sm-flex align-items-center py-4 border-bottom">';

      echo '<span class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">';
      echo '<img class="rounded-3" src="' . $category['category_image_url'] . '" alt="">';
      echo '</span>';

      echo '<div class="text-center text-sm-start">';

      echo '<h3 class="h6 product-title mb-2"><span>' . $category['category_name'] . '</span></h3>';

      echo '<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">Parent Category: <span class="fw-medium">' . getParentCategoryName($category['parent_category_id'], $conn) . '</span></div>';

      echo '<div class="d-flex justify-content-center justify-content-sm-start pt-3">';
      echo '<button class="btn bg-faded-info btn-icon me-2" type="button" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit text-info"></i></button>';
      echo '<form action="admin/php/delete-category.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="' . $category['category_id'] . '">
        <button type="submit" class="btn bg-faded-danger btn-icon" data-bs-toggle="tooltip" title="Delete" onclick="return confirm(\'Bạn có chắc chắn muốn xóa danh mục này?\')">
            <i class="ci-trash"></i>
        </button>
      </form>';
      echo '</div>';

      echo '</div>';
      echo '</div>';

      // Nếu danh mục có các danh mục con, gọi lại hàm để in danh mục con
      if (!empty($category['subcategories'])) {
        printCategories($category['subcategories'], $conn);
      }
    }
  } else {
    echo "Không có danh mục nào";
  }
}

printCategories($category_data['categories'], $conn);

// Hiển thị phân trang với Bootstrap
echo '<nav aria-label="Page navigation">';
echo '<ul class="pagination justify-content-center">';

// Hiển thị nút "Trước"
if ($page > 1) {
  echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
}

// Hiển thị các số trang
for ($i = 1; $i <= $category_data['total_pages']; $i++) {
  $active = ($i == $page) ? 'active' : '';
  echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
}

// Hiển thị nút "Tiếp theo"
if ($page < $category_data['total_pages']) {
  echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
}

echo '</ul>';
echo '</nav>';


// Đóng kết nối
$conn->close();
