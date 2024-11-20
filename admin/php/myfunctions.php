<?php

function redirect($url, $message)
{
  $_SESSION['message'] = $message;
  header('Location: ' . $url);
  exit();
}

// Hàm chuyển đổi chuỗi sang chữ thường không dấu
function convertToSlug($string)
{
  // Chuyển thành chữ thường
  $string = mb_strtolower($string, 'UTF-8');

  // Loại bỏ dấu tiếng Việt
  // Loại bỏ dấu tiếng Việt
  $string = preg_replace([
    '/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/',    // a
    '/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/',                      // e
    '/í|ì|ỉ|ĩ|ị/',                                    // i
    '/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/',          // o
    '/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/',                      // u
    '/ý|ỳ|ỷ|ỹ|ỵ/',                                   // y
    '/đ/',                                           // đ
    '/ç/',                                           // c
    '/ä|ë|ï|ö|ü/',                                   // a, e, i, o, u (special chars)
  ], [
    'a',
    'e',
    'i',
    'o',
    'u',
    'y',
    'd',
    'c',
    'a',      // replace with non-accented equivalents
  ], $string);
  // Thay dấu cách bằng dấu gạch dưới
  $string = preg_replace('/\s+/', '_', $string);

  return $string;
}

function deleteDirectory($dir)
{
  // Kiểm tra nếu thư mục tồn tại
  if (!is_dir($dir)) {
    return false;
  }

  // Lấy tất cả các file và thư mục con trong thư mục
  $files = array_diff(scandir($dir), array('.', '..'));

  foreach ($files as $file) {
    $filePath = $dir . DIRECTORY_SEPARATOR . $file;
    if (is_dir($filePath)) {
      // Nếu là thư mục con, gọi đệ quy để xóa
      deleteDirectory($filePath);
    } else {
      // Nếu là file, xóa nó
      unlink($filePath);
    }
  }

  // Sau khi xóa hết nội dung, xóa thư mục
  return rmdir($dir);
}

function copyDirectory($src, $dst)
{
  // Mở thư mục nguồn
  $dir = opendir($src);

  // Tạo thư mục đích nếu chưa tồn tại
  if (!file_exists($dst)) {
    mkdir($dst, 0777, true);
  }

  // Duyệt tất cả các file và thư mục con trong thư mục nguồn
  while (($file = readdir($dir)) !== false) {
    if ($file != '.' && $file != '..') {
      $srcPath = $src . DIRECTORY_SEPARATOR . $file;
      $dstPath = $dst . DIRECTORY_SEPARATOR . $file;

      if (is_dir($srcPath)) {
        // Nếu là thư mục, gọi đệ quy để sao chép thư mục con
        copyDirectory($srcPath, $dstPath);
      } else {
        // Nếu là file, sao chép nó
        copy($srcPath, $dstPath);
      }
    }
  }

  closedir($dir);
}

function getProductList($conn, $sort_by = "p.product_id", $which_category = "", $page = 1, $products_per_page = -1)
{
  // Kiểm tra tính hợp lệ của cột sắp xếp (chỉ cho phép các cột được định nghĩa trước)
  $allowed_sort_columns = ['p.price', 'p.created_at', 'p.name', 'p.product_id'];
  if (!in_array($sort_by, $allowed_sort_columns)) {
    $sort_by = 'p.product_id'; // Giá trị mặc định
  }

  // Thêm điều kiện category nếu có
  $where_clause = "";
  if (!empty($which_category)) {
    $where_clause = "WHERE p.category_id = " . intval($which_category);
  }

  // Tính toán phân trang
  $offset = ($page - 1) * $products_per_page;
  $limit_clause = $products_per_page > 0 ? "LIMIT $offset, $products_per_page" : "";

  // Truy vấn tổng số sản phẩm (không phân trang)
  $total_sql = "SELECT COUNT(*) AS total_product FROM products p";
  $total_result = $conn->query($total_sql);
  $total_product = $total_result->fetch_assoc()['total_product'] ?? 0;

  // Truy vấn lấy dữ liệu sản phẩm
  $sql = "SELECT p.*, c.category_name, pi.image_url
          FROM products p 
          JOIN categories c ON p.category_id = c.category_id 
          LEFT JOIN (
              SELECT product_id, MIN(image_url) AS image_url
              FROM product_images
              GROUP BY product_id
          ) pi ON p.product_id = pi.product_id
          ORDER BY $sort_by
          $limit_clause";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  // Lấy dữ liệu sản phẩm
  $products = [];
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }

  // Trả về danh sách sản phẩm và tổng số lượng
  return [
    'pC' => $products, // Danh sách sản phẩm
    'total_product' => $total_product // Tổng số sản phẩm
  ];
}
