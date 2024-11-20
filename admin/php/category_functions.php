<?php
require("php/conn.php");
// đổ ra giao diện dashboard category
// function getCategoriesIntoIndex($conn, $parent_id = null)
// {
//   $categories = [];

//   // Lấy các danh mục theo parent_id
//   $sql = "SELECT * FROM categories WHERE parent_category_id " . ($parent_id === null ? "IS NULL" : "= $parent_id");
//   $result = $conn->query($sql);

//   if ($result->num_rows > 0) {
//     while ($category = $result->fetch_assoc()) {
//       // Đệ quy để lấy các danh mục con
//       $category['subcategories'] = getCategoriesIntoIndex($conn, $category['category_id']);
//       $categories[] = $category;
//     }
//   }

//   return $categories;
// }

function getCategoriesIntoIndex($conn, $page = 1, $categories_per_page = 10)
{
  // Tính toán phân trang
  $offset = ($page - 1) * $categories_per_page;
  $limit_clause = $categories_per_page > 0 ? "LIMIT $offset, $categories_per_page" : "";

  // Truy vấn tổng số danh mục (không phân trang)
  $total_sql = "SELECT COUNT(*) AS total_category FROM categories";
  $total_result = $conn->query($total_sql);
  $total_category = $total_result->fetch_assoc()['total_category'] ?? 0;

  // Tính số trang tổng cộng
  $total_pages = ceil($total_category / $categories_per_page);

  // Truy vấn lấy dữ liệu danh mục có phân trang
  $sql = "SELECT * FROM categories ORDER BY category_id $limit_clause";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  // Lấy dữ liệu danh mục
  $categories = [];
  while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
  }

  // Trả về danh sách danh mục, tổng số danh mục và tổng số trang
  return [
    'categories' => $categories, // Danh sách danh mục
    'total_category' => $total_category, // Tổng số danh mục
    'total_pages' => $total_pages // Tổng số trang
  ];
}

// lấy tên danh mục cha 
function getParentCategoryName($parent_id, $conn)
{
  $parent_name = null;
  // Truy vấn lấy tên danh mục cha
  $sql = "SELECT category_name FROM categories WHERE category_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $parent_id);
  $stmt->execute();
  $stmt->bind_result($parent_name);
  $stmt->fetch();

  // Đóng statement
  $stmt->close();

  // Kiểm tra và trả về tên danh mục cha nếu tìm thấy, ngược lại trả về null
  return $parent_name ? $parent_name : "Không có";
}
