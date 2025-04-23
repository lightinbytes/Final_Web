<?php
require_once 'app/models/UserModel.php';

class AuthController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new UserModel();
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $model->login($email, $password);

            $response = [];

            if ($user) {
                $_SESSION['user'] = $user;
                $response = [
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'redirect' => '?controller=product&action=list'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Email hoặc mật khẩu không đúng!'
                ];
            }

            $this->sendJson($response);
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new UserModel();
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $response = ['success' => false];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = "Email không hợp lệ.";
            } elseif ($model->emailExists($email)) {
                $response['message'] = "Email đã tồn tại.";
            } elseif (strlen($password) < 6) {
                $response['message'] = "Mật khẩu phải có ít nhất 6 ký tự.";
            } elseif ($password !== $confirmPassword) {
                $response['message'] = "Mật khẩu xác nhận không trùng khớp.";
            } else {
                $model->register($email, $password);
                $response = [
                    'success' => true,
                    'message' => "Đăng ký thành công!",
                    'redirect' => '?controller=auth&action=login'
                ];
            }

            $this->sendJson($response);
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        $this->sendJson([
            'success' => true,
            'message' => 'Đăng xuất thành công!',
            'redirect' => '?controller=auth&action=login'
        ]);
    }

    private function sendJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}