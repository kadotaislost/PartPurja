<?php
require '../includes/database.php';

header("Content-Type: application/json");

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $conn = new Database();

    $commentsQuery = "SELECT comments.comment_text, users.full_name, users.profile_image, comments.created_at 
                      FROM comments 
                      LEFT JOIN users ON comments.user_id = users.user_id 
                      WHERE comments.product_id = ? 
                      ORDER BY comments.created_at DESC";

    $comments = $conn->select($commentsQuery, [$product_id]);

    echo json_encode($comments);
} else {
    echo json_encode(["error" => "Product ID not provided."]);
}
?>
