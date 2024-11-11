<?php

// hỗ trợ việc add cato 
function addCategory($conn, $name, $parentCategory, $imgFile, $path)
{
  $image_ext = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
  $filename = time() . '.' . $image_ext;

  $cate_query = "INSERT INTO categories (category_name, parent_category_id, category_image_url) VALUES ('$name', $parentCategory, '$filename')";
  $cate_query_run = mysqli_query($conn, $cate_query);

  if ($cate_query_run) {
    move_uploaded_file($imgFile['tmp_name'], $path . '/' . $filename);
    return true;
  } else {
    return false;
  }
}


// đổ ra giao diện 
function getCategoriesIntoIndex($conn)
{
  // Lấy danh sách các danh mục cha (parent_category_id = NULL)
  $sql = "SELECT * FROM categories WHERE parent_category_id IS NULL";
  $parentCategories = $conn->query($sql);

  $categories = [];

  if ($parentCategories->num_rows > 0) {
    while ($parent = $parentCategories->fetch_assoc()) {
      // Thêm danh mục cha vào mảng
      $categories[] = $parent;

      // Truy vấn để lấy các danh mục con của danh mục cha hiện tại
      $parent_id = $parent['category_id'];
      $childSql = "SELECT * FROM categories WHERE parent_category_id = $parent_id";
      $childCategories = $conn->query($childSql);

      // Thêm các danh mục con vào mảng
      if ($childCategories->num_rows > 0) {
        while ($child = $childCategories->fetch_assoc()) {
          $categories[] = $child;
        }
      }
    }
  }

  return $categories;
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
