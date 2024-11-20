<?php
require("php/conn.php");

if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'] ?? null;

  $sql = "SELECT * FROM products WHERE product_id = ?";
  $stmt1 = $conn->prepare($sql);
  $stmt1->bind_param("i", $product_id);
  $stmt1->execute();
  $result = $stmt1->get_result();
  $product = $result->fetch_assoc();

  if (!$product) {
    die("Sản phẩm không tồn tại.");
  }

  // Truy vấn ảnh
  $sql_images = "SELECT image_url FROM product_images WHERE product_id = ?";
  $stmt2 = $conn->prepare($sql_images);
  $stmt2->bind_param("i", $product_id);
  $stmt2->execute();
  $result_images = $stmt2->get_result();
  $images = [];

  while ($row = $result_images->fetch_assoc()) {
    $images[] = $row['image_url'];
  }

  //Truy vấn size và quantity
  $sql_quantity = "select size, quantity from product_quantity where product_id = ?";
  $stmt3 = $conn->prepare($sql_quantity);
  $stmt3->bind_param("i", $product_id);
  $stmt3->execute();
  $result_quantity = $stmt3->get_result();

  $sizes = [];
  $total_quantity = null;
  while ($row = $result_quantity->fetch_assoc()) {
    if (is_null($row['size'])) {
      $total_quantity = $row['quantity'];
    } else {
      $sizes[$row['size']] = $row['quantity'];
    }
  }

  $letterSizes = ['XS', 'S', 'M', 'L', 'XL'];

  $sizeType = 'number';

  if (!empty($sizes)) {
    // Kiểm tra nếu bất kỳ kích thước nào thuộc nhóm kích thước chữ
    foreach ($sizes as $key => $value) {
      if (in_array($key, $letterSizes)) {
        $sizeType = 'letter';
        break;
      }
    }
  } else {
    $sizeType = 'none'; // Nếu không có size nào thì là 'none'
  }
} else {
  echo "Lỗi không lấy được id sản phẩm";
  exit;
}