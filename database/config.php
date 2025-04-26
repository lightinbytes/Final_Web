<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

define('HOST', 'localhost');
define('DATABASE', 'online_shopping');
define('USERNAME', 'root');
define('PASSWORD', '');
define('ENVIRONMENT', 'development');
define('BASE_URL', 'http://localhost/Final_Web-main/public/');

try {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        die("Kết nối database thất bại: " . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}