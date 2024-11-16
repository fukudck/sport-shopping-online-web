<?php
require_once('../../php/conn.php');
require('get-categories.php');

if (isset($_POST['addProduct'])) {
  $product_name = $_POST['product-name'];
  $category = $_POST['category'];
  // implode(',', $_POST['size']): chuyển phần tử trong arr thành chuỗi cách nhua dấu ,
  $sizes = isset($_POST['size']) ? json_encode($_POST['size']) : '[]'; // Chuyển mảng thành JSON  
  $description = $_POST['description'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];

  $sql = "INSERT INTO products (name, description, price, stock_quantity, category_id,  sizes) 
            VALUES ('$product_name', '$description', '$price', '$stock' ,'$category', '$sizes')";

  // bước xử lý tạo đường dẫn lưu vào DB và folder trên máy
  if ($conn->query($sql) === TRUE) {
    $product_id = $conn->insert_id; // lấy ra id khi được tạo tự động

    $categoryHierarchy = getCategoryHierarchy($category, $conn); // Lấy phân cấp danh mục
    $categoryPath = implode('/', $categoryHierarchy); // Chuyển mảng thành chuỗi phân cấp với dấu "/"

    // Tạo đường dẫn cho ảnh
    $category_path = "img/img/$categoryPath/$product_id"; // Đường dẫn phân cấp danh mục và ID sản phẩm

    if (!file_exists($category_path)) {
      // Tạo thư mục phân cấp nếu chưa tồn tại
      mkdir("../../" . $category_path, 0777, true);
    }

    // Xử lý từng ảnh trong danh sách ảnh được upload
    foreach ($_FILES['product-images']['name'] as $key => $filename) {
      $tmp_name = $_FILES['product-images']['tmp_name'][$key];
      $image_name = pathinfo($filename, PATHINFO_FILENAME) . ".webp";
      $image_path = "$category_path/$image_name";

      $image = imagecreatefromstring(file_get_contents($tmp_name));
      imagewebp($image, "../../" . $image_path); // lưu vào thư mục
      imagedestroy($image);

      // Lưu đường dẫn ảnh vào bảng product_images
      $sql_image = "INSERT INTO product_images (product_id, image_url) VALUES ('$product_id', '$image_path')";
      $conn->query($sql_image);
    }

    header('Location: ../../dashboard-add-new-product.php');
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}