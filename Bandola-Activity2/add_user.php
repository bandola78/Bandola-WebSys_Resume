<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "127.0.0.1";
$port = "5432";
$dbname = "resume_db";
$user = "postgres";
$password = "0000";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Add test user
    $test_username = "admin";
    $test_password = "admin123";
    $hashed_password = password_hash($test_password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $test_username]);

    if ($stmt->rowCount() > 0) {
        echo "User 'admin' already exists!<br>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            'username' => $test_username,
            'password' => $hashed_password
        ]);
        echo "Test user created successfully!<br>";
        echo "<strong>Username:</strong> admin<br>";
        echo "<strong>Password:</strong> admin123<br>";
    }

    echo "<br><a href='login.php'>Go to Login Page</a>";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
