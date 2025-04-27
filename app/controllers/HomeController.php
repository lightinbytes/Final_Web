<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class HomeController {
    private $conn;

    public function __construct($conn) {
        if (!isset($conn) || is_null($conn)) {
            die("Lỗi: Biến \$conn không được khởi tạo trong HomeController.");
        }
        $this->conn = $conn;
    }

    public function index() {
        // Truyền $conn vào home.php
        $conn = $this->conn;
        require_once BASE_PATH . 'app/views/home.php';
    }

    public function login() {
        $conn = $this->conn; // Truyền $conn vào login.php
        require_once BASE_PATH . 'app/views/login.php';
    }

    public function signup() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = trim($_POST['password']);
            $repeat_password = trim($_POST['repeat_password']);

            require_once BASE_PATH . 'app/models/UserModel.php';
            $userModel = new UserModel($this->conn);
            $result = $userModel->signup($fullname, $email, $phone, $password, $repeat_password);

            if ($result['success']) {
                $success = $result['message'];
                header('Refresh: 2; URL=index.php?page=login');
            } else {
                $error = $result['error'];
            }
        }

        require_once BASE_PATH . 'app/views/signup.php';
    }

    public function contact() {
        require_once BASE_PATH . 'app/views/contact.php';
    }

    public function cart() {
        require_once BASE_PATH . 'app/views/cart.php';
    }

    public function checkout() {
        require_once BASE_PATH . 'app/views/checkout.php';
    }

    public function shop_grid() {
        require_once BASE_PATH . 'app/views/shop_grid.php';
    }

    public function shop_detail() {
        require_once BASE_PATH . 'app/views/shop_detail.php';
    }

    public function account() {
        require_once BASE_PATH . 'app/views/account.php';
    }
}
?>