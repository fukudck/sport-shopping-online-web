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
function updateUser($conn, $user_id, $first_name, $last_name, $phone_number, $new_password = null) {
    // Chuẩn bị câu lệnh SQL
    $sql = "UPDATE users SET first_name = ?, last_name = ?, phone_number = ?";
    $params = [$first_name, $last_name, $phone_number];

    // Nếu có mật khẩu mới
    if ($new_password) {
        $sql .= ", password_hash = ?";
        $params[] = hash('sha256', $new_password);
    }

    $sql .= " WHERE user_id = ?";
    $params[] = $user_id;

    // Chuẩn bị câu lệnh và thực thi
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);

    if ($stmt->execute()) {
        header("Location: ".$_SERVER['PHP_SELF']."?success=1");
    } else {
        header("Location: ".$_SERVER['PHP_SELF']."?error=1");
    }
}

function getUserData($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        header("Location: account-signin.php");
    }

    // Đóng statement
    $stmt->close();
}

function getAddress($conn, $user_id) {
    $sql = "SELECT * FROM user_shipping_addresses WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $addresses = [];
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }
    return $addresses;


}

if (!function_exists('findNameById')) {
    function findNameById($id, $array, $key = 'Id', $nameKey = 'Name') {
        foreach ($array as $item) {
            if ($item[$key] == $id) {
                return $item[$nameKey];
            }
        }
        return null;
    }
}

function convertAddressIdsToNames($address) {
    // Đường dẫn đến JSON trực tuyến
    $jsonUrl = 'https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json';

    // Lấy dữ liệu JSON từ URL
    $jsonData = file_get_contents($jsonUrl);
    $locations = json_decode($jsonData, true);

    // Lấy tên Tỉnh/Thành phố
    $cityName = findNameById($address['city'], $locations);

    // Lấy tên Quận/Huyện từ Tỉnh/Thành phố
    $districtName = null;
    $wardName = null;
    foreach ($locations as $city) {
        if ($city['Id'] == $address['city']) {
            $districtName = findNameById($address['district'], $city['Districts']);
            
            // Lấy tên Phường/Xã từ Quận/Huyện
            foreach ($city['Districts'] as $district) {
                if ($district['Id'] == $address['district']) {
                    $wardName = findNameById($address['ward'], $district['Wards']);
                    break;
                }
            }
            break;
        }
    }

    // Trả về địa chỉ đã chuyển đổi
    return $address['first_name'] . " " . 
           $address['last_name'] . " " . 
           $address['detailed_address'] . ", " . 
           $wardName . ", " . 
           $districtName . ", " . 
           $cityName;
}

function getPayment($conn, $user_id) {
    $sql = "SELECT * FROM user_payment_methods WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payments = [];
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    return $payments;


}
?>


