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
define('BASE_URL', 'http://localhost/Final Project _Group07/');
define('BASE_PATH', dirname(__DIR__) . '/');
date_default_timezone_set('Asia/Ho_Chi_Minh');

try {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    if (ENVIRONMENT === 'development') {
        die($e->getMessage());
    } else {
        error_log($e->getMessage());
        die('An error occurred. Please try again later.');
    }
}