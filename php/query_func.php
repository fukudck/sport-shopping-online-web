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

function getRandomProducts($conn, $which_category = "", $number = 8) {
    if (!empty($which_category)) {
        $which_category = "WHERE p.category_id = " . $which_category;
    }
    $stmt = $conn->prepare(
        "SELECT p.*, c.category_name , pi.image_url
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        LEFT JOIN (
            SELECT product_id, MIN(image_url) AS image_url
            FROM product_images
            GROUP BY product_id
        ) pi ON p.product_id = pi.product_id
        $which_category
        ORDER BY RAND() 
        LIMIT $number
    ");
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
		$products[] = $row;
	}
    return $products;
}

function getProductDetails($conn, $product_id) {
    $sql = "SELECT 
                p.product_id,
                p.name,
                p.description,
                p.price,
                p.category_id,
                p.created_at,
                GROUP_CONCAT(DISTINCT 
                    CASE 
                        WHEN pq.size IS NOT NULL THEN CONCAT(pq.size, ':', pq.quantity)
                        ELSE CONCAT('No Size:', pq.quantity) 
                    END
                SEPARATOR ', ') AS sizes_quantities,
                GROUP_CONCAT(DISTINCT CONCAT(pi.image_id, ':', pi.image_url) SEPARATOR ', ') AS image_urls
            FROM 
                products p
            LEFT JOIN 
                product_quantity pq ON p.product_id = pq.product_id
            LEFT JOIN 
                product_images pi ON p.product_id = pi.product_id
            WHERE 
                p.product_id = ?
            GROUP BY 
                p.product_id;
            ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $product_details = [];

        $product_details['product_id'] = $row['product_id'];
        $product_details['name'] = $row['name'];
        $product_details['description'] = $row['description'];
        $product_details['price'] = $row['price'];
        $product_details['category_id'] = $row['category_id'];
        $product_details['created_at'] = $row['created_at'];
        $product_details['stock_quantity'] = 0;

        // Tách size, quantity, img
        $sizes_quantities = $row['sizes_quantities'];
        $size_quantity_array = explode(", ", $sizes_quantities); // Tách theo dấu phẩy

        $product_details['sizes'] = [];
            if (isset($sizes_quantities)){
            foreach ($size_quantity_array as $size_quantity) {
                list($size, $quantity) = explode(":", $size_quantity); // Tách size và quantity
                if($quantity > 0) {
                    $product_details['sizes'][] = ['size' => $size, 'quantity' => $quantity];
                    $product_details['stock_quantity'] += $quantity;
                }
            }
        }

        $image_urls = $row['image_urls'];
        $image_urls_array = explode(", ", $image_urls);

        $product_details['image_urls'] = [];
        foreach ($image_urls_array as $image_url) {
            list($image_id, $image_url) = explode(":", $image_url); // Tách image_id và image_url
            $product_details['image_urls'][] = ['image_id' => $image_id, 'image_url' => $image_url];
        }

        $stmt->close();
        return $product_details;
    } else {
        $stmt->close();
        return null;
    }
}

?>