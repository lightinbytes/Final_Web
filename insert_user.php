<?php
define('BASEPATH', true);
define('BASE_PATH', dirname(__DIR__) . '/Final_Web-main/');

require_once BASE_PATH . 'database/config.php';

$hash = '$2y$10$5bXz7lZ8y9k2m3n4p5q6r7t8u9v0w1x2y3z4a5b6c7d8e9f0g1h2i3';
$sql = "DELETE FROM users WHERE username = 'testuser'";
$conn->query($sql);

$sql = "INSERT INTO users (id, username, email, phone, password, name, date_of_birth, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$id = 1;
$username = 'testuser';
$email = 'test@example.com';
$phone = '0123456789';
$name = 'TDTU';
$date_of_birth = '2005-01-01';
$gender = 'female';
$stmt->bind_param("isssssss", $id, $username, $email, $phone, $hash, $name, $date_of_birth, $gender);
$stmt->execute();

echo "Thêm bản ghi thành công!";
?>