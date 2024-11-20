<?php
include_once '../../php/conn.php';

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
  $category_id = $_POST['id'];

  // Bước 1: Xóa sản phẩm và dữ liệu liên quan đến sản phẩm trong danh mục và danh mục con
  $deleteProductsQuery = "DELETE FROM products WHERE category_id IN (SELECT category_id FROM categories WHERE category_id = ? OR parent_category_id = ?)";
  $stmt = $conn->prepare($deleteProductsQuery);
  $stmt->bind_param("ii", $category_id, $category_id);
  $stmt->execute();
  $stmt->close();

  // Xóa ảnh liên quan đến sản phẩm
  $deleteImagesQuery = "DELETE FROM product_images WHERE product_id IN (SELECT product_id FROM products WHERE category_id IN (SELECT category_id FROM categories WHERE category_id = ? OR parent_category_id = ?))";
  $stmt = $conn->prepare($deleteImagesQuery);
  $stmt->bind_param("ii", $category_id, $category_id);
  $stmt->execute();
  $stmt->close();

  // Xóa size liên quan đến sản phẩm
  $deleteSizeQuery = "DELETE FROM product_quantity WHERE product_id IN (SELECT product_id FROM products WHERE category_id IN (SELECT category_id FROM categories WHERE category_id = ? OR parent_category_id = ?))";
  $stmt = $conn->prepare($deleteSizeQuery);
  $stmt->bind_param("ii", $category_id, $category_id);
  $stmt->execute();
  $stmt->close();

  // Xóa danh mục con
  $deleteSubCategoriesQuery = "DELETE FROM categories WHERE parent_category_id = ?";
  $stmt = $conn->prepare($deleteSubCategoriesQuery);
  $stmt->bind_param("i", $category_id);
  $stmt->execute();
  $stmt->close();

  // Xóa danh mục cha
  $deleteCategoryQuery = "DELETE FROM categories WHERE category_id = ?";
  $stmt = $conn->prepare($deleteCategoryQuery);
  $stmt->bind_param("i", $category_id);
  if ($stmt->execute()) {
    // Thành công
    echo "<script>alert('Danh mục và các sản phẩm liên quan đã được xóa thành công!'); window.location.href='../../dashboard-categories.php';</script>";
  } else {
    // Lỗi
    echo "<script>alert('Đã có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại!');</script>";
  }
} else {
  echo "ID không hợp lệ";
}
