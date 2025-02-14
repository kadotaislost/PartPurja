<?php
session_start();
require_once 'database.php';
require_once 'mailer.php';

if (!isset($_SESSION['temp_user'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['resend_code'])) {
        // Regenerate verification code
        $verification_code = rand(1000, 9999);
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['verification_time'] = time();

        // Send new code to email
        $subject = "Resend: Email Verification Code";
        $message = "Your new verification code is: <strong>" . $verification_code . "</strong> (Expires in 1 minute)";
        sendMail($_SESSION['temp_user']['email'], $subject, $message);
        $message_sent = "A new verification code has been sent to your email.";
    } else {
        $entered_code = trim($_POST['verification_code']);
        
        if (time() - $_SESSION['verification_time'] > 60) {
            $error = "Verification code expired. Please request a new one.";
        } elseif ($entered_code == $_SESSION['verification_code']) {
            $conn = new Database();
            $sql = "INSERT INTO users (full_name, email, password_hash, phone, is_verified) VALUES (?, ?, ?, ?, 1)";
            $user = $_SESSION['temp_user'];
            $returnId = $conn->create($sql, [$user['full_name'], $user['email'], $user['password_hash'], $user['phone']]);

            if ($returnId) {
                unset($_SESSION['verification_code'], $_SESSION['verification_time'], $_SESSION['temp_user']);
                header("Location: login.php");
                exit();
            } else {
                $error = "Error creating account.";
            }
        } else {
            $error = "Invalid verification code.";
        }
    }
}

$title = "Verify Email";
include '../includes/header.php';
?>

<div class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Verify Your Email</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error mb-4 flex items-center justify-between">
                <span><?php echo $error; ?></span>
                <button onclick="this.parentElement.style.display='none'" class="text-red-800 font-bold text-lg">&times;</button>

            </div>
        <?php endif; ?>
        
        <?php if (!empty($message_sent)): ?>
            <div class="alert alert-success mb-4 flex items-center justify-between">
                <span><?php echo $message_sent; ?></span>
                <button onclick="this.parentElement.style.display='none'" class="text-red-800 font-bold text-lg">&times;</button>

            </div>
        <?php endif; ?>
        
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Enter Verification Code</label>
                <input type="text" name="verification_code" class="input input-bordered w-full" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-full">Verify</button>
        </form>
        
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="mt-4">
            <button type="submit" name="resend_code" class="btn btn-secondary w-full">Resend Code</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
