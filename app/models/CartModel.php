<?php
class CartModel {
    public function addToCart($productId) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 1;
        } else {
            $_SESSION['cart'][$productId]++;
        }
    }

    public function updateItem($id, $qty) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = $qty;
        }
    }

    public function removeItem($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public function getTotal() {
        $total = 0;
        $items = $this->getCartItems();
        $productModel = new ProductModel();
        foreach ($items as $id => $qty) {
            $product = $productModel->getProductById($id);
            if ($product) {
                $total += $product['price'] * $qty;
            } else {
                error_log("Sản phẩm với ID $id không tồn tạitại.");
            }
        }
        return $total;
    }

    public function getCartItems() {
        return $_SESSION['cart'] ?? [];
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
    }
}