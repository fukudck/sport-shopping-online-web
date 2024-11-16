<?php
require_once('../../php/conn.php');
require('get-categories.php');

if (isset($_POST['addProduct'])) {
  $product_name = $_POST['product-name'];
  $category = $_POST['category'];
  // implode(',', $_POST['size']): chuyển phần tử trong arr thành chuỗi cách nhua dấu ,
  $description = $_POST['description'];
  $price = $_POST['price'];
  // Lấy giá trị loại size
  $sizeType = $_POST['sizeType'];

  $sql = "INSERT INTO products (name, description, price, category_id) 
            VALUES ('$product_name', '$description', '$price' ,'$category')";

  // bước xử lý tạo đường dẫn lưu vào DB và folder trên máy
  if ($conn->query($sql) === TRUE) {
    $product_id = $conn->insert_id; // lấy ra id khi được tạo tự động

    if ($sizeType === 'none') {
      // Nếu không có kích thước, chỉ lưu tổng số lượng
      $total_quantity = (int)$_POST['total_quantity'];
      $stmt = $conn->prepare("INSERT INTO product_quantity (product_id, size, quantity) VALUES (?, NULL, ?)");
      $stmt->bind_param("ii", $product_id, $total_quantity);
      $stmt->execute();
      $stmt->close();
    } else {
      // Nếu có kích thước, lưu từng size và số lượng
      foreach ($_POST['size'] as $size => $quantity) {
        $quantity = (int)$quantity; // Chuyển đổi thành số nguyên
        if ($quantity > 0) { // Chỉ lưu những size có số lượng > 0
          $stmt = $conn->prepare("INSERT INTO product_quantity (product_id, size, quantity) VALUES (?, ?, ?)");
          $stmt->bind_param("isi", $product_id, $size, $quantity);
          $stmt->execute();
        }
      }
      $stmt->close();
    }

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
