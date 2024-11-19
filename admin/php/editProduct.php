<?php
require_once('../../php/conn.php');
require('get-categories.php');

if (isset($_POST['editProduct'])) {
  $product_id = $_POST['product_id'];
  $product_name = $_POST['product-name'];
  $category = $_POST['category'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  // Lấy giá trị loại size
  $sizeType = $_POST['sizeType'];

  $sql = "UPDATE products 
  SET name = '$product_name', 
      description = '$description', 
      price = '$price', 
      category_id = '$category' 
  WHERE product_id = '$product_id'";

  echo $sql;
  if ($conn->query($sql) === TRUE) {
    // Xóa dữ liệu cũ trong bảng product_quantity
    $stmt = $conn->prepare("DELETE FROM product_quantity WHERE product_id = ?");
    if (!$stmt) {
      echo "Lỗi chuẩn bị DELETE: " . $conn->error;
    }
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
      echo "Lỗi thực thi DELETE: " . $stmt->error;
    }
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();

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
        $quantity = (int)$quantity;
        if ($quantity > 0) { // Chỉ lưu những size có số lượng > 0
          $stmt = $conn->prepare("INSERT INTO product_quantity (product_id, size, quantity) VALUES (?, ?, ?)");
          $stmt->bind_param("isi", $product_id, $size, $quantity);
          $stmt->execute();
        }
      }
      $stmt->close();
    }
    echo "Sản phẩm đã được chỉnh sửa thành công.";
  } else {
    echo "Lỗi: " . $conn->error;
  }

  // Lấy phân cấp danh mục mới
  $newHierarchy = getCategoryHierarchy($category, $conn);
  $newPath = "img/img/" . implode('/', $newHierarchy) . "/$product_id";
  echo  $newPath;

  // bước xử lý tạo đường dẫn lưu vào DB và folder trên máy
  if ($conn->query($sql) === TRUE) {
    if ($_POST['old_category_id'] != $category) {
      // Lấy phân cấp danh mục cũ
      $currentHierarchy = getCategoryHierarchy($_POST['old_category_id'], $conn);
      $currentPath = "img/img/" . implode('/', $currentHierarchy) . "/$product_id";
      echo  $currentPath;

      if (file_exists("../../" . $currentPath)) {
        // Tạo thư mục mới nếu chưa tồn tại
        if (!file_exists("../../" . ($newPath))) {
          mkdir($newPath, 0777, true);
        }

        // Di chuyển toàn bộ nội dung từ thư mục cũ sang thư mục mới
        rename("../../" . $currentPath, "../../" . $newPath);
      }

      $sql_update_images = "UPDATE product_images 
                      SET image_url = REPLACE(image_url, '$currentPath', '$newPath')
                      WHERE product_id = ?";
      $stmt = $conn->prepare($sql_update_images);
      $stmt->bind_param("i", $product_id);
      $stmt->execute();
      $stmt->close();
    } else {
      echo "lỗi về danh mục";
    }

    // Thay thế ảnh nếu có 
    // 1. Xóa ảnh cũ khỏi DB và thư mục
    $sql_select_images = "SELECT image_url FROM product_images WHERE product_id = ?";
    $stmt = $conn->prepare($sql_select_images);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $filePath = "../../" . $row['image_url'];
      if (file_exists($filePath)) {
        unlink($filePath); // Xóa file ảnh
      }
    }
    $stmt->close();

    // Xóa các bản ghi trong bảng product_images
    $sql_delete_images = "DELETE FROM product_images WHERE product_id = ?";
    $stmt = $conn->prepare($sql_delete_images);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();

    // 2. Thêm ảnh mới
    foreach ($_FILES['product-images']['name'] as $key => $filename) {
      $tmp_name = $_FILES['product-images']['tmp_name'][$key];
      $image_path = "$newPath/" . pathinfo($filename, PATHINFO_FILENAME) . ".webp";

      $image = imagecreatefromstring(file_get_contents($tmp_name));
      imagewebp($image, "../../" . $image_path); // lưu vào thư mục
      imagedestroy($image);

      // Lưu đường dẫn ảnh vào bảng product_images
      $sql_image = "INSERT INTO product_images (product_id, image_url) VALUES ('$product_id', '$image_path')";
      $conn->query($sql_image);
    }

    header("Location: ../../dashboard-edit-product.php?product_id=$product_id");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "loi";
}