<?php
require_once 'app/models/CartModel.php';
require_once 'app/models/ProductModel.php';

class CartController {
    private $productModel;

    private function getCartCount() {
        $cart = $_SESSION['cart'] ?? [];
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    private function calculateCartTotal($cart) {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function __construct(mysqli $conn) {
        $this->productModel = new ProductModel($conn);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        $total = $this->calculateCartTotal($cart);
    
        if (isAjaxRequest()) {
            sendJsonResponse(true, "Cart retrieved.", [
                'cart' => $cart,
                'total' => $total
            ]);
        } else {
            require 'app/views/cart.php';
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = (int)($_POST['quantity'] ?? 1);
    
            if ($productId <= 0 || $quantity <= 0) {
                if (isAjaxRequest()) {
                    sendJsonResponse(false, "Invalid product or quantity.");
                } else {
                    $_SESSION['error'] = "Invalid product or quantity.";
                    header("Location: " . BASE_URL . "index.php?controller=product&action=index");
                    exit;
                }
            }
    
            $product = $this->productModel->getProductById($productId);
            if (!$product) {
                if (isAjaxRequest()) {
                    sendJsonResponse(false, "Product not found.");
                } else {
                    $_SESSION['error'] = "Product not found.";
                    header("Location: " . BASE_URL . "index.php?controller=product&action=index");
                    exit;
                }
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
    
            if (isAjaxRequest()) {
                sendJsonResponse(true, "Product added to cart.", [
                    'cart_count' => $this->getCartCount(),
                    'total' => $this->calculateCartTotal($_SESSION['cart'])
                ]);
            } else {
                header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                exit;
            }
        }
    
        if (isAjaxRequest()) {
            sendJsonResponse(false, "Invalid request method.");
        } else {
            header("Location: " . BASE_URL . "index.php?controller=product&action=index");
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = (int)($_POST['quantity'] ?? 0);
    
            if ($productId <= 0 || $quantity < 0) {
                if (isAjaxRequest()) {
                    sendJsonResponse(false, "Invalid product or quantity.");
                } else {
                    $_SESSION['error'] = "Invalid product or quantity.";
                    header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                    exit;
                }
            }
    
            if (isset($_SESSION['cart'][$productId])) {
                if ($quantity == 0) {
                    unset($_SESSION['cart'][$productId]);
                } else {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                }
    
                if (isAjaxRequest()) {
                    sendJsonResponse(true, "Cart updated.", [
                        'cart_count' => $this->getCartCount(),
                        'total' => $this->calculateCartTotal($_SESSION['cart'])
                    ]);
                } else {
                    header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                    exit;
                }
            }
    
            if (isAjaxRequest()) {
                sendJsonResponse(false, "Product not in cart.");
            } else {
                $_SESSION['error'] = "Product not in cart.";
                header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                exit;
            }
        }
    
        if (isAjaxRequest()) {
            sendJsonResponse(false, "Invalid request method.");
        } else {
            header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
            exit;
        }
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
    
            if ($productId <= 0) {
                if (isAjaxRequest()) {
                    sendJsonResponse(false, "Invalid product.");
                } else {
                    $_SESSION['error'] = "Invalid product.";
                    header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                    exit;
                }
            }
    
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
    
                if (isAjaxRequest()) {
                    sendJsonResponse(true, "Product removed.", [
                        'cart_count' => $this->getCartCount(),
                        'total' => $this->calculateCartTotal($_SESSION['cart'])
                    ]);
                } else {
                    header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                    exit;
                }
            }
    
            if (isAjaxRequest()) {
                sendJsonResponse(false, "Product not in cart.");
            } else {
                $_SESSION['error'] = "Product not in cart.";
                header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
                exit;
            }
        }
    
        if (isAjaxRequest()) {
            sendJsonResponse(false, "Invalid request method.");
        } else {
            header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
            exit;
        }
    }

    public function clear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_SESSION['cart']);
    
            if (isAjaxRequest()) {
                sendJsonResponse(true, "Cart cleared.", ['cart_count' => 0, 'total' => 0]);
            } else {
                header("Location: " . BASE_URL . "index.php?controller=product&action=index");
                exit;
            }
        }
    
        if (isAjaxRequest()) {
            sendJsonResponse(false, "Invalid request method.");
        } else {
            header("Location: " . BASE_URL . "index.php?controller=cart&action=index");
            exit;
        }
    }
}