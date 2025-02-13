<?php 
session_start();
require_once 'database.php';
require_once 'mailer.php'; // Include mailer script

// Redirect logged-in users to index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = trim($_POST['role']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $conn = new Database();
        $sql = "SELECT id FROM users WHERE email = ?";
        $count = $conn->countRows($sql, [$email]);

        if ($count > 0) {
            $error = "This email is already registered.";
        } else {
            // Generate 4-digit verification code
            $verification_code = rand(1000, 9999);
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['verification_time'] = time(); // Store time for expiration
            $_SESSION['temp_user'] = [
                'name' => $name,
                'email' => $email,
                'password' => sha1(md5($password)),
                'role' => $role
            ];

            // Send verification code to email
            $subject = "Email Verification Code";
            $message = "Your verification code is: <strong>" . $verification_code . "</strong> (Expires in 1 minute)";
            $emailResult = sendMail($email, $subject, $message);

            if (strpos($emailResult, "Error") !== false) {
                $error = "Error sending verification code. Please try again.";
            } else {
                header("Location: verify.php");
                exit();
            }
        }
    }
}

$title = "Register";
include '../includes/header.php';
?>

<div class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Register</h2>
        
       
        
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" class="input input-bordered w-full" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="input input-bordered w-full" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="input input-bordered w-full" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" class="input input-bordered w-full" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="input input-bordered w-full" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary w-full">Register</button>
        </form>
        
        <p class="text-center mt-4">
            Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a>
        </p>

        <?php if (!empty($error)): ?>
            <div class="flex items-center justify-between bg-red-300 text-red-800 p-4 rounded-lg mb-4">
                <span><?php echo $error; ?></span>
                <button onclick="this.parentElement.style.display='none'" class="text-red-800 font-bold text-lg">&times;</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
