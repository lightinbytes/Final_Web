<?php
require_once 'app/models/CartModel.php';
require_once 'app/models/ProductModel.php';

class CartController {

    public function add($id) {
        $productModel = new ProductModel();
        if (!$productModel->getProductById($id)) {
            $_SESSION['error'] = "Sản phẩm không tồn tại.";
            header("Location: ?controller=cart&action=view");
            exit;
        }
        $cart = new CartModel();
        $cart->addToCart($id);
        $_SESSION['message'] = "Sản phẩm đã được thêm vào giỏ hàng.";
        header("Location: ?controller=cart&action=view");
        exit;
    }

    public function updateQuantity($id, $qty) {
        $cart = new CartModel();
        $cart->updateItem($id, $qty);
        $_SESSION['message'] = "Số lượng sản phẩm đã được cập nhật.";
        header("Location: ?controller=cart&action=view");
        exit;
    }

    public function view() {
        $cart = new CartModel();
        $items = $cart->getCartItems();
        $productModel = new ProductModel();
        $products = [];
        foreach ($items as $id => $qty) {
            $p = $productModel->getProductById($id);
            if ($p) {
                $p['qty'] = $qty;
                $products[] = $p;
            }
        }
        require 'app/views/cart.php';
    }

    public function remove($id) {
        $cart = new CartModel();
        $cart->removeItem($id);
        $_SESSION['message'] = "Sản phẩm đã được xóa khỏi giỏ hàng.";
        header("Location: ?controller=cart&action=view");
        exit;
    }

    public function clear() {
        $cart = new CartModel();
        $cart->clearCart();
        $_SESSION['message'] = "Giỏ hàng đã được làm sạch.";
        header("Location: ?controller=cart&action=view");
        exit;
    }
}