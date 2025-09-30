<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Initialize variables
$fullname = '';
$username = '';
$password = '';
$register_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"] ?? '');
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($fullname) || empty($username) || empty($password)) {
        $register_err = "Please fill in all fields.";
    } else {
        $host = "127.0.0.1";
        $port = "5432";
        $dbname = "resume_db";
        $dbuser = "postgres";
        $dbpass = "0000";

        try {
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $dbuser, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if username already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);

            if ($stmt->rowCount() > 0) {
                $register_err = "Username already taken. Please choose another.";
            } else {
                // Insert new user with fullname and current timestamp
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("
                    INSERT INTO users (fullname, username, password, created_at)
                    VALUES (:fullname, :username, :password, NOW())
                ");
                $stmt->execute([
                    'fullname' => $fullname,
                    'username' => $username,
                    'password' => $hashed_password
                ]);

                // Redirect to login after registration
                header("Location: login.php");
                exit;
            }

        } catch (PDOException $e) {
            $register_err = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Resume Portal</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body class="login-body">
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>REGISTER</h1>
                <p>Create an account to access Bandola's portfolio</p>
            </div>

            <?php 
            if (!empty($register_err)) {
                echo '<div class="alert alert-error">' . $register_err . '</div>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
                <div class="form-group">
                    <label for="fullname">FULL NAME</label>
                    <input 
                        type="text" 
                        id="fullname" 
                        name="fullname" 
                        class="form-input" 
                        value="<?php echo htmlspecialchars($fullname, ENT_QUOTES); ?>" 
                        placeholder="Enter your full name"
                    >
                </div>

                <div class="form-group">
                    <label for="username">USERNAME</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input" 
                        value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" 
                        placeholder="Choose a username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter a password"
                    >
                    <div>
                        <input type="checkbox" id="show-password" onclick="togglePassword()"> Show Password
                    </div>
                </div>

                <button type="submit" class="login-btn">REGISTER</button>
            </form>

            <div class="login-footer">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>