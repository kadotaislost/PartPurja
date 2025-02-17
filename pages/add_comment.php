<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

require '../includes/database.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $conn = new Database();
    $comment = trim($_POST['comment_text']);
    $post_id = (int)$_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    if(empty($comment)){
        $error = "Comment field is required.";
    }else{
        $conn = new Database();
        $sql = "INSERT INTO comments (comment_text, product_id, user_id) VALUES (?, ?, ?)";
        $conn->create($sql, [$comment, $post_id, $user_id]);
        $_SESSION['success'] = "Comment added successfully.";
        header("Location: product.php?id=$post_id");
        exit();
      
    }
}

?>