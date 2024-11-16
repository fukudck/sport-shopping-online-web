<?php
session_start();
require_once('../../php/conn.php');
require('myfunctions.php');
require_once('category_functions.php');
require("get-categories.php");

if (isset($_POST["submit"])) {
  $name = $_POST['category_name'];
  $parentCategory = $_POST['parent_category'];
  $imgFile = $_FILES['category_image'];

  // insert lần để lấy được category_id
  $cate_query = "INSERT INTO categories (category_name, parent_category_id) VALUES ('$name', $parentCategory)";
  if ($conn->query($cate_query) === TRUE) {
    $category_id = $conn->insert_id; // lấy ra id khi được tạo tự động  $categoryHierarchy = getCategoryHierarchy($category_id, $conn); // Lấy phân cấp danh mục
    $categoryHierarchy = getCategoryHierarchy($category_id, $conn); // Lấy phân cấp danh mục
    $categoryPath = implode('/', $categoryHierarchy); // Chuyển mảng thành chuỗi phân cấp với dấu "/"

    // Tạo đường dẫn cho ảnh
    $category_path = "img/img/$categoryPath"; // Đường dẫn phân cấp danh mục và ID sản phẩm

    echo $category_path;
    if (!file_exists($category_path)) {
      // Tạo thư mục phân cấp nếu chưa tồn tại
      mkdir("../../" . $category_path, 0777, true);
    }

    $filename = $imgFile['name'];
    $tmp_name = $imgFile['tmp_name'];
    $image_name = pathinfo($filename, PATHINFO_FILENAME) . ".webp";
    $image_path = "$category_path/$image_name";

    // Xử lý và lưu ảnh dưới dạng webp
    $image = imagecreatefromstring(file_get_contents($tmp_name));
    if ($image !== false) {
      imagewebp($image, "../../" . $image_path); // lưu vào thư mục
      imagedestroy($image);
    }

    $sql_update_img = "UPDATE categories SET category_image_url = '$image_path' WHERE category_id = $category_id";
    $conn->query($sql_update_img);
    redirect("../../dashboard-add-new-category.php", "Category added successfully");
  } else {
    echo "Lỗi thêm danh mục";
  }
}