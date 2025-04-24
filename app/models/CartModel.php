<?php
require_once 'app/models/ProductModel.php';

class CartModel {
    private $productModel;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->productModel = new ProductModel($conn);
    }

    public function addToCart($productId, $quantity = 1) {
        if ($quantity <= 0) {
            throw new Exception("Invalid quantity.");
        }

        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            throw new Exception("Product not found.");
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    public function getCartItems() {
        return $_SESSION['cart'] ?? [];
    }

    public function updateQuantity($productId, $quantity) {
        if ($quantity < 0) {
            throw new Exception("Invalid quantity.");
        }

        if (isset($_SESSION['cart'][$productId])) {
            if ($quantity == 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
            }
        }
    }

    public function removeItem($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
    }

    public function getCartCount() {
        $cart = $_SESSION['cart'] ?? [];
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function calculateCartTotal() {
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}