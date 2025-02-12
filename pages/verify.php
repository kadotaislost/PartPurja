<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['temp_user'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['verification_code']);

    if ($entered_code == $_SESSION['verification_code']) {
        // Retrieve user data from session
        $conn = new Database();
        $sql = "INSERT INTO users (name, email, password, verified) VALUES (?, ?, ?, 1)";
        $user = $_SESSION['temp_user'];
        $returnId = $conn->create($sql, [$user['name'], $user['email'], $user['password']]);

        if ($returnId) {
            unset($_SESSION['verification_code'], $_SESSION['temp_user']);
            header("Location: login.php");
            exit();
        } else {
            $error = "Error creating account.";
        }
    } else {
        $error = "Invalid verification code.";
    }
}

$title = "Verify Email";
include '../includes/header.php';
?>

<div class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Verify Your Email</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error mb-4">
                <span><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Enter Verification Code</label>
                <input type="text" name="verification_code" class="input input-bordered w-full" required>
            </div>

            <button type="submit" class="btn btn-primary w-full">Verify</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
