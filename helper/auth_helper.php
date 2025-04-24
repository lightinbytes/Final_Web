<?php
require_once 'database/config.php';

function isLoggedIn() {
    return isset($_SESSION['user']); // Kiểm tra người dùng đã đăng nhập chưa
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php?page=login"); // Chuyển hướng nếu chưa đăng nhập
        exit();
    }
}

function loginUser($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $password) { // nên dùng password_verify nếu đã hash
        $_SESSION['user'] = [
            'username' => $user['username'],
            'email' => $user['email']
        ];
        return true;
    }

    return false;
}

function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function sendJsonResponse($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
