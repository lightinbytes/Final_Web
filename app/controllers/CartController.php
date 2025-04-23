<?php
require_once 'app/models/CartModel.php';
require_once 'app/models/ProductModel.php';

class CartController {

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            // Giả sử bạn đã có hàm thêm sản phẩm vào giỏ
            $cart = $_SESSION['cart'] ?? [];
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }
            $_SESSION['cart'] = $cart;

            // Trả về kết quả dưới dạng JSON cho AJAX
            echo json_encode([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ!',
                'cart_count' => count($cart)  // Trả về số lượng sản phẩm trong giỏ
            ]);
            exit;
        }

        // Nếu không phải POST, trả về lỗi
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi thêm sản phẩm vào giỏ!'
        ]);
        exit;
    }

    // Cập nhật giỏ hàng (thay đổi số lượng)
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            // Kiểm tra nếu giỏ hàng có sản phẩm
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = $quantity;

                // Trả về kết quả cập nhật giỏ hàng
                echo json_encode([
                    'success' => true,
                    'message' => 'Giỏ hàng đã được cập nhật!',
                    'cart_count' => array_sum($_SESSION['cart'])  // Tổng số sản phẩm trong giỏ
                ]);
                exit;
            }

            // Nếu không có sản phẩm trong giỏ
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
            ]);
            exit;
        }
    }

    // Xóa sản phẩm khỏi giỏ
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];

            // Kiểm tra nếu sản phẩm trong giỏ
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);

                // Trả về kết quả xóa sản phẩm
                echo json_encode([
                    'success' => true,
                    'message' => 'Sản phẩm đã được xóa khỏi giỏ!',
                    'cart_count' => count($_SESSION['cart'])  // Cập nhật số lượng giỏ hàng
                ]);
                exit;
            }

            // Nếu không tìm thấy sản phẩm trong giỏ
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm để xóa!'
            ]);
            exit;
        }
    }
}

