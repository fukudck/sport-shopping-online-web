<?php
include_once  'category_functions.php';
include_once 'php/conn.php';
include_once "myfunctions.php";

$current_page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
  ? intval($_GET['page'])
  : 1;

$sort_by = $_GET['sort_by'] ?? 'product_id'; // Giá trị mặc định nếu không có sort_by

$products_per_page = 7;

// Lấy danh sách sản phẩm
$product_list = getProductList($conn, $sort_by, "", $current_page, $products_per_page);
$products = $product_list['pC'];
$total_products = $product_list['total_product'];



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
