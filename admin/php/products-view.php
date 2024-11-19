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
