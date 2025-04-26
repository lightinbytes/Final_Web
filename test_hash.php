<?php
define('BASEPATH', true);
define('BASE_PATH', dirname(__DIR__) . '/Final_Web-main/');

require_once BASE_PATH . 'database/config.php';

$sql = "SELECT password FROM users WHERE username = 'testuser'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$hash = $user['password'];
$password = 'password123';

echo "Hash từ DB: $hash<br>";
echo "Dài hash: " . strlen($hash) . "<br>";
if (password_verify($password, $hash)) {
    echo "Hash khớp với password123!";
} else {
    echo "Hash không khớp!";
}
?>