<?php
ob_start();
require '../includes/database.php';
$title = "Profile";
include '../includes/header.php';
include '../includes/navbar.php';

// Fetch user details from the database (assuming session holds user_id)
// session_start();
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    $conn = new Database();
    $sql = "SELECT full_name, email, phone, profile_image, created_at FROM users WHERE user_id = ?";
    $user = $conn->select($sql, [$user_id])[0] ?? null;
}

// Fetch posts by the user
// $productsQuery = "SELECT * FROM products WHERE user_id = ? ORDER BY created_at DESC";
// $products = $conn->select($productsQuery, [$user_id]);
$productsQuery = "SELECT p.*, (SELECT image_url FROM product_images WHERE product_images.product_id = p.product_id LIMIT 1) AS product_image 
                  FROM products p 
                  WHERE p.user_id = ? 
                  ORDER BY p.created_at DESC";
$products = $conn->select($productsQuery, [$user_id]);


// Handel Post Deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM products WHERE product_id = ?";
    $conn->delete($sql, [$product_id]);
    $_SESSION['success'] = "Post deleted successfully!";
    header("Location: profile.php");
    ob_end_flush();
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $uploadDir = '../assets/profile_pictures/';
        $profile_image = $uploadDir . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image);
        $sql = "UPDATE users SET full_name=?, email=?, phone=?, profile_image=? WHERE user_id=?";
        $conn->update($sql, [$full_name, $email, $phone, $profile_image, $user_id]);
    } else {
        $sql = "UPDATE users SET full_name=?, email=?, phone=? WHERE user_id=?";
        $conn->update($sql, [$full_name, $email, $phone, $user_id]);
    }
    $_SESSION['success'] = "Profile updated successfully!";
    $_SESSION['full_name'] = $full_name;
    $_SESSION['profile_image'] = $profile_image;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    header("Location: profile.php");
    ob_end_flush();
    exit();
}
?>

<div class="container max-w-7xl mx-auto ">
    <div class="grid grid-cols-1 md:grid-cols-7 gap-6">
        <!-- Left Section: Profile Information (3/7 ratio) -->
        <div class="col-span-3 bg-white p-6 rounded-lg shadow-md">
            <div class="text-center">
            <img src="<?= !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : '../assets/profile_pictures/default.png'; ?>" 
     alt="Profile Picture" 
     class="w-32 h-32 mx-auto rounded-full border border-gray-300">

                <h2 class="text-xl font-semibold mt-4"> <?= $user['full_name'] ?? 'User'; ?> </h2>
                <p class="text-gray-600">Phone: <?= $user['phone'] ?? 'N/A'; ?></p>
                <p class="text-gray-600">Joined: <?= date('F j, Y', strtotime($user['created_at'] ?? '')); ?></p>
                <!-- <button onclick="toggleEdit()" class="btn btn-primary mt-4">Edit Profile</button> -->
            </div>
        
            <!-- Hidden Form for Editing Profile -->
            <!-- <div id="edit-profile" class="hidden mt-4"> -->
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <label class="block mt-2">Profile Picture</label>
                    <input type="file" name="profile_image" class="input input-bordered w-full">
                    <label class="block mt-2">Full Name</label>
                    <input type="text" name="full_name" value="<?= $user['full_name'] ?? ''; ?>" class="input input-bordered w-full">
                    <label class="block mt-2">Email</label>
                    <input type="email" name="email" value="<?= $user['email'] ?? ''; ?>" class="input input-bordered w-full">
                    <label class="block mt-2">Phone</label>
                    <input type="text" name="phone" value="<?= $user['phone'] ?? ''; ?>" class="input input-bordered w-full">
                    <button type="submit" class="btn btn-primary mt-4 w-full">Update Profile</button>
                </form>
            <!-- </div> -->
        </div>
        
        <!-- Right Section: Posts & Comments Toggle (4/7 ratio) -->
        <div class="col-span-4 bg-white p-6 rounded-lg shadow-md">
            
            <!-- Posts Section
            <div id="posts" class="mt-4">
                <h3 class="text-xl font-bold">Your Posts</h3>
                <p class="text-gray-600">(List of posts will go here)</p>
            </div> -->
            <h3 class="text-xl font-bold mb-4">Your Posts</h3>

            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($products as $product): ?>
                        <div class="border border-gray-200 rounded-lg shadow-md overflow-hidden">
                            <!-- Product Image -->
                            <img src="<?= !empty($product['product_image']) ? '../assets/' . htmlspecialchars($product['product_image']) : '../assets/no-image.png'; ?>"
                                 alt="Product Image"
                                 class="w-full h-40 object-cover">

                            <div class="p-4">
                                <h4 class="text-lg font-semibold"><?= htmlspecialchars($product['title']); ?></h4>
                                <p class="text-gray-600"><?= htmlspecialchars($product['description']); ?></p>
                                <p class="text-sm text-gray-500"><?= date("F j, Y, g:i a", strtotime($product['created_at'])); ?></p>

                                <!-- View & Delete Buttons -->
                                <div class="flex gap-2 mt-4">
                                    <!-- View Button (Navigates to product.php) -->
                                    <a href="product.php?id=<?= $product['product_id']; ?>" class="btn btn-info w-1/2 text-center">View</a>
                                    
                                    <!-- Delete Post Button -->
                                    <form action="profile.php" method="POST" class="w-1/2">
                                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                                        <button type="submit" class="btn btn-error w-full">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500">You have not posted anything yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
