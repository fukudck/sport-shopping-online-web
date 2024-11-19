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