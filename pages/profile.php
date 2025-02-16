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
                <button onclick="toggleEdit()" class="btn btn-primary mt-4">Edit Profile</button>
            </div>
        
            <!-- Hidden Form for Editing Profile -->
            <div id="edit-profile" class="hidden mt-4">
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
            </div>
        </div>
        
        <!-- Right Section: Posts & Comments Toggle (4/7 ratio) -->
        <div class="col-span-4 bg-white p-6 rounded-lg shadow-md">
            <div class="tabs">
                <button onclick="toggleSection('posts')" class="tab tab-bordered tab-active">Posts</button>
                <button onclick="toggleSection('comments')" class="tab tab-bordered">Comments</button>
            </div>
            
            <!-- Posts Section -->
            <div id="posts" class="mt-4">
                <h3 class="text-lg font-semibold">Your Posts</h3>
                <p class="text-gray-600">(List of posts will go here)</p>
            </div>
            
            <!-- Comments Section (Initially Hidden) -->
            <div id="comments" class="hidden mt-4">
                <h3 class="text-lg font-semibold">Your Comments</h3>
                <p class="text-gray-600">(List of comments will go here)</p>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit() {
    document.getElementById('edit-profile').classList.toggle('hidden');
}

function toggleSection(section) {
    document.getElementById('posts').classList.add('hidden');
    document.getElementById('comments').classList.add('hidden');
    document.getElementById(section).classList.remove('hidden');
}
</script>

<?php include '../includes/footer.php'; ?>
