<?php
require '../includes/database.php';

header("Content-Type: application/json");

$conn = new Database();

// Get category_id from GET request
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Modify query to filter by category if category_id is provided
$productsQuery = "SELECT products.*, product_images.image_url, users.full_name
                  FROM products 
                  LEFT JOIN product_images ON products.product_id = product_images.product_id 
                  LEFT JOIN users ON products.user_id = users.user_id";

if ($category_id > 0) {
    $productsQuery .= " WHERE products.category_id = :category_id";
}

$productsQuery .= " GROUP BY products.product_id ORDER BY created_at DESC";

$params = $category_id > 0 ? ['category_id' => $category_id] : [];

$productsResult = $conn->select($productsQuery, $params);

// Encode the products as JSON and return
echo json_encode($productsResult);
?>
