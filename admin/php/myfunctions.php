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