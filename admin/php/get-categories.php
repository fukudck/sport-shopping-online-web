<?php

// function getCategories($conn, $parent_id = null)
// {
//   $categories = [];

//   $stmt = $conn->prepare("SELECT * FROM categories WHERE parent_category_id  = ?");
//   $stmt->bind_param("i", $parent_id);
//   $stmt->execute();
//   $result = $stmt->get_result();

//   while ($row = $result->fetch_assoc()) {
//     $row['children'] = getCategories($conn, $row['category_id']);
//     $categories[] = $row;
//   }

//   $stmt->close();

//   return $categories;
// }

function getCategories($conn)
{
  $categories = [];
  $sql = "SELECT * FROM categories";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $categories[] = $row;
    }
  }
  return $categories;
}



function displayCategoryOptions($categories, $parentId = null, $level = 0)
{
  foreach ($categories as $category) {
    if ($category['parent_category_id'] == $parentId) {
      // In ra option cho danh mục hiện tại
      echo '<option value="' . $category['category_id'] . '"';

      // Nếu là option đã được chọn (nếu có)
      if (isset($_POST['parent_category']) && $_POST['parent_category'] == $category['category_id']) {
        echo ' selected';
      }

      echo '>' . str_repeat('-- ', $level) . $category['category_name'] . '</option>';

      // Gọi đệ quy để in các danh mục con (nếu có)
      displayCategoryOptions($categories, $category['category_id'], $level + 1);
    }
  }
}
