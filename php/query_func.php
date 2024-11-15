<?php 
function getProductList($conn, $sort_by_price = "p.product_id", $which_category = "", $page = 1, $products_per_page = -1) {
    if (!empty($which_category)) {
        $which_category = "WHERE p.category_id = " . $which_category;
    }
    $sql = "SELECT p.*, c.category_name, pi.image_url
    FROM products p 
    JOIN categories c ON p.category_id = c.category_id 
    LEFT JOIN (
			SELECT product_id, MIN(image_url) AS image_url
			FROM product_images
			GROUP BY product_id
		) pi ON p.product_id = pi.product_id
    $which_category
    ORDER BY $sort_by_price";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_result = $result->num_rows;
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Thêm từng dòng vào mảng
    }
    if ($products_per_page != -1) {
        $chunks = array_chunk($products, $products_per_page);
        $chunk = $chunks[$page - 1] ?? null; // Kiểm tra nếu chunk không tồn tại

        return ['pC' => $chunk, 'total_product' => $total_result];
    } else {
        return ['pC' => $products, 'total_product' => $total_result];
    }
}

function getCategoryList($conn) {
    $categories = [];
    $sub_categories = [];
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $stmt = $stmt->get_result();
    while ($row = $stmt->fetch_assoc()) {
        if ($row['parent_category_id'] == NULL) {
            $categories[] = $row;
        } else {
            $sub_categories[] = $row;
        }
    }
    return ['categories' => $categories, 'sub_categories' => $sub_categories];
}

?>