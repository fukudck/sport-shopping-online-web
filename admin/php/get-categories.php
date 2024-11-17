<?php
require_once("myfunctions.php");
// function getCategories($conn, $parent_id = null)
// {
//   $categories = [];

//   $stmt = $conn->prepare("SELECT * FROM categories WHERE parent_category_id  = ?");
//   $stmt->bind_param("i", $parent_id);
//   $stmt->execute();
//   $result = $stmt->get_result();

//   while ($row = $result->fetch_assoc()) {
//     $row['children'] = getCategories($conn, $row['category_id']);
//     $categories[] = $row;
//   }

//   $stmt->close();

//   return $categories;
// }

function getCategories($conn)
{
  $categories = [];
  $sql = "SELECT * FROM categories";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $categories[] = $row;
    }
  }
  return $categories;
}


// lấy phân cấp danh mục để chọn danh mục cha 
function displayCategoryOptions($categories, $parentId = null, $level = 0)
{
  foreach ($categories as $category) {
    if ($category['parent_category_id'] == $parentId) {
      // In ra option cho danh mục hiện tại
      echo '<option value="' . $category['category_id'] . '"';

      // Nếu là option đã được chọn (nếu có)
      if (isset($_POST['parent_category']) && $_POST['parent_category'] == $category['category_id']) {
        echo ' selected';
      }

      echo '>' . str_repeat('-- ', $level) . $category['category_name'] . '</option>';

      // Gọi đệ quy để in các danh mục con (nếu có)
      displayCategoryOptions($categories, $category['category_id'], $level + 1);
    }
  }
}

// hàm tạo 1 arr phân cấp danh mục dựa vào id để lưu vào img
function getCategoryHierarchy($category_id, $conn)
{
  $categoryPath = [];

  // Lấy thông tin danh mục từ cơ sở dữ liệu
  $sql = "SELECT category_name, parent_category_id FROM categories WHERE category_id = $category_id";
  $result = $conn->query($sql);

  if (!$result) {
    die("SQL Error: " . $conn->error);  // In ra lỗi nếu truy vấn không thành công
  }

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Chuyển đổi tên danh mục thành chữ thường không dấu và thay dấu cách bằng dấu "_"
    $categoryName = convertToSlug($row['category_name']);
    $categoryPath[] = $categoryName;

    // Nếu danh mục có cha, tiếp tục lấy danh mục cha
    if ($row['parent_category_id']) {
      $parentCategories = getCategoryHierarchy($row['parent_category_id'], $conn);
      $categoryPath = array_merge($parentCategories, $categoryPath); // Gộp danh mục cha vào trước
    }
  }

  return $categoryPath;
}