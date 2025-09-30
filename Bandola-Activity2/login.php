<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Initialize variables
$username = '';
$login_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($username) || empty($password)) {
        $login_err = "Please enter both username and password.";
    } else {
        $host = "127.0.0.1";
        $port = "5432";
        $dbname = "resume_db";
        $dbuser = "postgres";
        $dbpass = "0000";

        try {
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $dbuser, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: resume.php");
                    exit;
                } else {
                    $login_err = "Invalid username or password.";
                }
            } else {
                $login_err = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $login_err = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Resume Portal</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body class="login-body">
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>LOGIN</h1>
                <p>Sign in to access Bandola's portfolio</p>
            </div>

            <?php if (!empty($login_err)): ?>
                <div class="alert alert-error"><?= $login_err ?></div>
            <?php endif; ?>

            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="login-form">
                <div class="form-group">
                    <label for="username">USERNAME</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input" 
                        value="<?= htmlspecialchars($username, ENT_QUOTES) ?>" 
                        placeholder="Enter your username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                    >
                </div>
                <div>
                    <input type="checkbox" id="show-password" onclick="togglePassword()"> Show Password
                </div>
                
                <button type="submit" class="login-btn">SIGN IN</button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="registration.php">Sign In</a></p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
