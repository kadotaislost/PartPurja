<?php
require '../includes/database.php';

header("Content-Type: application/json");

$conn = new Database();

$productsQuery = "SELECT products.*, product_images.image_url, users.full_name
                  FROM products 
                  LEFT JOIN product_images ON products.product_id = product_images.product_id 
                  LEFT JOIN users ON products.user_id = users.user_id
                  GROUP BY products.product_id
                  ORDER BY created_at DESC";

$productsResult = $conn->select($productsQuery);

// Encode the products as JSON and return
echo json_encode($productsResult);
?>
