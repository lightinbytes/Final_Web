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

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Lỗi kết nối MySQLi: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>