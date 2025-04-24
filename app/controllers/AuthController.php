<?php
require_once 'app/models/UserModel.php';
require_once 'helpers/auth_helper.php';

class AuthController {
    private $userModel;

    public function __construct(mysqli $conn) {
        $this->userModel = new UserModel($conn);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        // Nếu đã đăng nhập
        if (isset($_SESSION['user'])) {
            if (isAjaxRequest()) {
                sendJsonResponse(true, "Already logged in.", ['redirect' => BASE_URL . "index.php?controller=home&action=index"]);
            } else {
                header("Location: index.php?controller=home&action=index");
                exit();
            }
        }

        $error = '';
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = $_POST['identifier'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kiểm tra dữ liệu rỗng
            if (empty($identifier) || empty($password)) {
                $error = "Please provide both identifier and password.";
                if (empty($identifier)) {
                    $errors['identifier'] = "Identifier is required.";
                }
                if (empty($password)) {
                    $errors['password'] = "Password is required.";
                }
                if (isAjaxRequest()) {
                    sendJsonResponse(false, $error, ['errors' => $errors]);
                }
            } else {
                try {
                    $user = $this->userModel->getUserByIdentifier($identifier);
                    if ($user && password_verify($password, $user['password'])) {
                        $_SESSION['user'] = [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'email' => $user['email']
                        ];
                        if (isAjaxRequest()) {
                            sendJsonResponse(true, "Login successful.", ['redirect' => BASE_URL . "index.php?controller=home&action=index"]);
                        } else {
                            header("Location: index.php?controller=home&action=index");
                            exit();
                        }
                    } else {
                        $error = "Invalid identifier or password.";
                        if (isAjaxRequest()) {
                            sendJsonResponse(false, $error);
                        }
                    }
                } catch (Exception $e) {
                    $error = "An error occurred: " . $e->getMessage();
                    if (isAjaxRequest()) {
                        sendJsonResponse(false, $error);
                    }
                }
            }
        }

        // Phản hồi cho yêu cầu không phải POST
        if (isAjaxRequest()) {
            sendJsonResponse(false, $error ?: "Invalid request method.");
        } else {
            require 'app/views/login.php';
        }
    }

    public function register() {
        $error = '';
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy và lọc dữ liệu
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Kiểm tra dữ liệu rỗng
            if (empty($username)) {
                $errors['username'] = "Username is required.";
            }
            if (empty($email)) {
                $errors['email'] = "Email is required.";
            }
            if (empty($phone)) {
                $errors['phone'] = "Phone is required.";
            }
            if (empty($password)) {
                $errors['password'] = "Password is required.";
            }

            // Xác thực dữ liệu
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }
            if (!empty($phone) && !preg_match('/^[0-9]{10,12}$/', $phone)) {
                $errors['phone'] = "Invalid phone number.";
            }
            if (!empty($password) && strlen($password) < 8) {
                $errors['password'] = "Password must be at least 8 characters.";
            }
            if ($password !== $confirmPassword) {
                $errors['confirm_password'] = "Mật khẩu không khớp";
            }

            // Nếu có lỗi, trả về phản hồi
            if (!empty($errors)) {
                $error = "Please correct the errors below.";
                if (isAjaxRequest()) {
                    sendJsonResponse(false, $error, ['errors' => $errors]);
                } else {
                    require 'app/views/auth/register.php';
                    return;
                }
            }

            try {
                // Kiểm tra username trùng lặp
                $existingUser = $this->userModel->getUserByIdentifier($username);
                if ($existingUser) {
                    $errors['username'] = "Username đã tồn tại";
                    $error = $errors['username'];
                    if (isAjaxRequest()) {
                        sendJsonResponse(false, $error, ['errors' => $errors]);
                    } else {
                        require 'app/views/auth/register.php';
                        return;
                    }
                }

                // Lưu người dùng vào cơ sở dữ liệu
                // $this->userModel->createUser($username, $email, $phone, $password);

                // Phản hồi thành công
                if (isAjaxRequest()) {
                    sendJsonResponse(true, "Registration successful.", ['redirect' => BASE_URL . "index.php?controller=auth&action=login"]);
                } else {
                    if (!headers_sent()) {
                        header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
                        exit;
                    } else {
                        echo "<script>window.location.href='" . BASE_URL . "index.php?controller=auth&action=login';</script>";
                        exit;
                    }
                }
            } catch (Exception $e) {
                $error = ENVIRONMENT === 'development' ? "An error occurred: " . $e->getMessage() : "An error occurred. Please try again later.";
                if (isAjaxRequest()) {
                    sendJsonResponse(false, $error);
                } else {
                    require 'app/views/auth/register.php';
                    return;
                }
            }
        }

        // Phản hồi cho yêu cầu không phải POST
        if (isAjaxRequest()) {
            sendJsonResponse(false, "Invalid request method.");
        } else {
            require 'app/views/auth/register.php';
        }
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xóa session người dùng
            unset($_SESSION['user']);
            // Xóa giỏ hàng nếu cần
            unset($_SESSION['cart']);

            if (isAjaxRequest()) {
                sendJsonResponse(true, "Logged out successfully.", [
                    'redirect' => BASE_URL . "index.php?controller=home&action=index"
                ]);
            } else {
                header("Location: " . BASE_URL . "index.php?controller=home&action=index");
                exit;
            }
        }

        if (isAjaxRequest()) {
            sendJsonResponse(false, "Invalid request method.");
        } else {
            header("Location: " . BASE_URL . "index.php?controller=home&action=index");
            exit;
        }
    }
}