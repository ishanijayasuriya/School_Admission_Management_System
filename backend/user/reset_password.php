 <?php
require_once '../db_config.php';

// ----------------------
// Handle form submission
// ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        echo "Passwords do not match!";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check token validity (without using NOW() in SQL)
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token");
    $stmt->execute(['token' => $token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset && strtotime($reset['expires_at']) > time()) {
        // Update password in users table
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $stmt->execute([
            'password' => $hashedPassword,
            'user_id' => $reset['user_id']
        ]);

        // Delete the used token
        $pdo->prepare("DELETE FROM password_resets WHERE token = :token")->execute(['token' => $token]);

        echo " Password updated successfully. <a href='../../Front-end/user/login.html'>Go to Login</a>";
    } else {
        echo " Invalid or expired reset link.";
    }
    exit();
}

// ----------------------
//  Handle token validation and form display
// ----------------------
elseif (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Get token details
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token");
    $stmt->execute(['token' => $token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reset) {
        echo " Token not found in database.";
        exit();
    }

    if (strtotime($reset['expires_at']) <= time()) {
        echo " Token has expired.";
        exit();
    }

    // Token is valid, show password reset form
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Reset Your Password</title>
        <link rel="stylesheet" href="../../Front-end/css/u-style.css">
    </head>
    <body>
    <div class="container">
        <h2>Create a New Password</h2>
        <form method="POST" action="">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password:</label>
                <input type="password" name="confirm" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>
    </body>
    </html>
    <?php
} else {
    echo " No reset token provided.";
}
?>
