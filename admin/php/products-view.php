<?php
include_once  'category_functions.php';
include_once 'php/conn.php';

$sql = "SELECT products.product_id, products.name, products.price, products.created_at, images.image_url
        FROM products
        JOIN (
            SELECT product_id, MIN(image_url) AS image_url
            FROM product_images
            GROUP BY product_id
        ) AS images ON products.product_id = images.product_id";
$result = $conn->query($sql);

$products = []; // Biến lưu trữ dữ liệu sản phẩm

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
}

// Xóa sản phẩm 
// Kiểm tra nếu có yêu cầu xóa sản phẩm
if (isset($_POST['delete'])) {
  $product_id = intval($_POST['product_id']); // Kiểm tra và chuyển đổi thành int để bảo mật

  // Xóa ảnh liên quan đến sản phẩm
  $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $stmt->close();

  // Xóa size liên quan đến sản phẩm
  $stmt = $conn->prepare("DELETE FROM product_quantity WHERE product_id = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $stmt->close();

  // Xóa sản phẩm khỏi bảng products
  $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
  $stmt->bind_param("i", $product_id);
  if ($stmt->execute()) {
    // Thành công
    echo "<script>alert('Sản phẩm đã được xóa thành công!'); window.location.href='dashboard-products.php';</script>";
  } else {
    // Lỗi
    echo "<script>alert('Đã có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại!');</script>";
  }
  $stmt->close();
}