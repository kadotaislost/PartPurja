<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'database.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new Database();
    $sql = "SELECT * FROM users WHERE email = ? AND password_hash = ?";
    $hashed_password = sha1(md5($password));
    $result = $conn->select($sql, [$email, $hashed_password]);
    
    if (!empty($result) && count($result) === 1) {
        $user = $result[0];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];

        if (isset($_POST["remember"])) {
            setcookie("user_email", $_POST["email"], time()+60*60*24*30, "/");  // 30 days
            setcookie("user_password", $_POST["password"], time()+60*60*24*30, "/");
        }
        else{
            setcookie("user_email", "", time()-3600, "/");
            setcookie("user_password", "", time()-3600 , "/");
        }
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid Credentials.";
    }
}

function setValue($field) {
    if(isset($_COOKIE[$field])){
        echo $_COOKIE[$field];
    }
}

function setChecked($field) {
    if(isset($_COOKIE[$field])){
        echo "checked='checked'";
    }
}

$title = "Login";
include '../includes/header.php';
?>

<div class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Login</h2>
        
        
        
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="input input-bordered w-full" value="<?php setValue("user_email"); ?>" required >
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="input input-bordered w-full" value="<?php setValue("user_password"); ?>" required >
            </div>

            <div class="mb-4">
                <input type="checkbox" name="remember" <?php setChecked("user_email")?>> Remember Me
            </div>
            
            <button type="submit" class="btn btn-primary w-full">Login</button>
        </form>
        
        <p class="text-center mt-4">
            Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Register here</a>
        </p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="flex items-center justify-between bg-red-300 text-red-800 p-4 rounded-lg mb-4">
                <span><?php echo $_SESSION['error']; ?></span>
                <button onclick="this.parentElement.style.display='none'" class="text-red-800 font-bold text-lg">&times;</button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
