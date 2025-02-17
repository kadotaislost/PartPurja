<?php
session_start();
require '../includes/database.php';

$conn = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['request_title']);
    $description = trim($_POST['description']);
    $category_id = (int)$_POST['category_id'];
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($description) || empty($category_id)) {
        $error = "All fields are required.";
    } else {
        $sql = "INSERT INTO product_requests (request_title, description, category_id, user_id) VALUES (?, ?, ?, ?)";
        $conn->create($sql, [$title, $description, $category_id, $user_id]);
        $_SESSION['success'] = "Request added successfully.";
        header("Location: requests.php");
        exit();
    }
}

?>