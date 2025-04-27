<?php
// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once BASE_PATH . 'app/views/layout/header.php';
include_once BASE_PATH . 'app/views/layout/header_content.php';

// Kiểm tra $conn
if (!isset($conn) || is_null($conn)) {
    error_log("Error: \$conn not initialized in home.php");
    die("Lỗi: Biến \$conn không được khởi tạo.");
}

try {
    // Lấy danh mục gốc
    $stmt = $conn->query("SELECT * FROM categories WHERE parent_id IS NULL");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Categories count: " . count($categories));

    // Lấy sản phẩm kèm ảnh thumbnail
    $stmt = $conn->query("
        SELECT p.*, pi.image_path, c.category_name
        FROM products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.thumbnail = b'1'
        LEFT JOIN categories c ON p.category_id = c.category_id
        WHERE p.is_active = 1 AND p.is_deleted = 0
        ORDER BY p.product_id DESC
        LIMIT 8
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Products count: " . count($products));

    // Log để debug
    foreach ($products as $product) {
        error_log("Product ID: {$product['product_id']}, Image Path: " . ($product['image_path'] ?? 'null'));
    }

    // Latest Products
    $stmt = $conn->query("
        SELECT p.*, pi.image_path
        FROM products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.thumbnail = b'1'
        WHERE p.is_active = 1 AND p.is_deleted = 0
        ORDER BY p.product_updated DESC
        LIMIT 3
    ");
    $latestProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Latest Products count: " . count($latestProducts));

    // Top Rated Products
    $stmt = $conn->query("
        SELECT p.*, pi.image_path
        FROM products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.thumbnail = b'1'
        WHERE p.is_active = 1 AND p.is_deleted = 0
        ORDER BY p.sold_quantity DESC
        LIMIT 3
    ");
    $topRatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Top Rated Products count: " . count($topRatedProducts));

    // Review Products
    $stmt = $conn->query("
        SELECT p.*, pi.image_path
        FROM products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.thumbnail = b'1'
        WHERE p.is_active = 1 AND p.is_deleted = 0
        ORDER BY RAND()
        LIMIT 3
    ");
    $reviewProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Review Products count: " . count($reviewProducts));
} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    die("Lỗi PDO: " . $e->getMessage());
}
?>

<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Departments</span>
                    </div>
                    <ul class="hero__categories__list">
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="?page=shop_grid&category_id=<?= urlencode($category['category_id']); ?>">
                                    <?= htmlspecialchars($category['category_name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="?page=search_results" method="GET">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" name="keyword" placeholder="What do you need?" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>090 636 4541</h5>
                            <span>Support 24/7 time</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="<?php echo BASE_URL; ?>img/hero/banner.jpg">
                    <div class="hero__text">
                        <span>FRUIT FRESH</span>
                        <h2>Vegetable <br />100% Organic</h2>
                        <p>Free Pickup and Delivery Available</p>
                        <a href="#" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php foreach ($categories as $category): ?>
                    <?php
                    $categoryImage = !empty($category['icon_path']) 
                        ? BASE_URL . htmlspecialchars($category['icon_path']) 
                        : BASE_URL . 'img/categories/default.jpg';
                    error_log("Category ID: {$category['category_id']}, Icon Path: " . ($category['icon_path'] ?? 'null'));
                    ?>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="<?php echo $categoryImage; ?>">
                            <h5><a href="?page=shop_grid&category_id=<?= urlencode($category['category_id']); ?>">
                                <?= htmlspecialchars($category['category_name']); ?>
                            </a></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Products</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <?php foreach ($categories as $category): ?>
                            <li data-filter=".<?php echo strtolower(str_replace(' ', '-', $category['category_name'])); ?>">
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <?php foreach ($products as $product): ?>
                <?php
                $imagePath = !empty($product['image_path']) 
                    ? BASE_URL . htmlspecialchars($product['image_path']) 
                    : BASE_URL . 'img/product/default.jpg';
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix <?php echo strtolower(str_replace(' ', '-', $product['category_name'] ?? 'unknown')); ?>">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="<?php echo $imagePath; ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="?page=cart&action=add&id=<?php echo $product['product_id']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="?page=shop_detail&id=<?php echo $product['product_id']; ?>">
                                <?php echo htmlspecialchars($product['name_product']); ?>
                            </a></h6>
                            <h5>
                                <?php
                                if ($product['discount_price'] && $product['discount_price'] > 0) {
                                    echo '$' . number_format($product['discount_price'], 2);
                                    echo ' <span style="text-decoration: line-through; color: #999;">$' . number_format($product['price'], 2) . '</span>';
                                } else {
                                    echo '$' . number_format($product['price'], 2);
                                }
                                ?>
                            </h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="<?php echo BASE_URL; ?>img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="<?php echo BASE_URL; ?>img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <?php
            $productGroups = [
                'Latest Products' => $latestProducts,
                'Top Rated Products' => $topRatedProducts,
                'Review Products' => $reviewProducts
            ];
            foreach ($productGroups as $title => $group): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4><?php echo $title; ?></h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <?php foreach ($group as $product): ?>
                                    <?php
                                    $imagePath = !empty($product['image_path']) 
                                        ? BASE_URL . htmlspecialchars($product['image_path']) 
                                        : BASE_URL . 'img/product/default.jpg';
                                    ?>
                                    <a href="?page=shop_detail&id=<?php echo $product['product_id']; ?>" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="<?php echo $imagePath; ?>" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6><?php echo htmlspecialchars($product['name_product']); ?></h6>
                                            <span>
                                                <?php
                                                if ($product['discount_price'] && $product['discount_price'] > 0) {
                                                    echo '$' . number_format($product['discount_price'], 2);
                                                } else {
                                                    echo '$' . number_format($product['price'], 2);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<!-- CSS tùy chỉnh -->
<style>
/* ===== Tiêu đề Featured Products và Latest Products ===== */
.section-title,
.latest-product__text {
    text-align: center;
}

.section-title h2,
.latest-product__text h4 {
    position: relative;
    display: block;
    padding-bottom: 1px;
    margin-bottom: 30px;
    font-weight: bold;
    color: #333;
}

.section-title h2::after,
.latest-product__text h4::after {
    content: "";
    display: block;
    margin: 10px auto 0;
    width: 100px;
    height: 3px;
    background-color: #ff0000;
}

/* ===== Sản phẩm Featured ===== */
.featured__item {
    background: #fff;
    border: 1px solid #eee;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 20px 15px;
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.featured__item:hover {
    border: 1px solid #ff0000;
    box-shadow: 0px 12px 24px rgba(0,0,0,0.2);
    transform: translateY(-8px) scale(1.02);
    background: #fafafa;
}

.featured__item__pic {
    width: 100%;
    height: 300px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    transition: transform 0.5s ease;
}

.featured__item:hover .featured__item__pic {
    transform: scale(1.05);
}

.featured__item__pic__hover {
    position: absolute;
    bottom: -50px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    opacity: 0;
    transition: all 0.5s ease;
}

.featured__item:hover .featured__item__pic__hover {
    bottom: 15px;
    opacity: 1;
}

.featured__item__pic__hover li {
    list-style: none;
}

.featured__item__pic__hover li i {
    width: 44px;
    height: 44px;
    background: #fff;
    color: #333;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.4s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    font-size: 18px;
}

.featured__item__pic__hover li i:hover {
    background: #ff0000;
    color: #fff;
    transform: scale(1.2) rotate(15deg);
}

.featured__item__text {
    margin-top: 15px;
    text-align: center;
}

.featured__item__text h6 a {
    font-size: 17px;
    font-weight: bold;
    color: #333;
    text-decoration: none;
    transition: color 0.4s ease;
}

.featured__item__text h6 a:hover {
    color: #ff0000;
}

.featured__item__text h5 {
    font-size: 20px;
    font-weight: bold;
    color: #000;
    margin-top: 8px;
}

/* Layout Featured */
.featured__filter {
    display: flex;
    flex-wrap: wrap;
}

.featured__filter .mix {
    width: 25%;
    flex: 0 0 25%;
    max-width: 25%;
    padding: 10px;
}

/* ===== Latest Products, Top Rated, Review Products ===== */
.latest-product__item {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 12px 15px;
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.4s ease;
    min-height: 140px;
}

.latest-product__item:hover {
    border: 1px solid #ff0000;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
    background: #fafafa;
}

.latest-product__item__pic {
    width: 120px;
    height: 120px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 10px;
    overflow: hidden;
    margin-right: 10px;
    flex-shrink: 0;
}

.latest-product__item__pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.latest-product__item__text {
    flex: 1;
}

.latest-product__item__text h6 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin: 0;
    line-height: 1.4;
    transition: color 0.4s ease;
}

.latest-product__item__text h6:hover {
    color: #ff0000;
}

.latest-product__item__text span {
    display: block;
    margin-top: 6px;
    font-size: 17px;
    color: #000;
    font-weight: bold;
}

/* Đảm bảo set-bg hoạt động */
.set-bg {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>

<!-- JavaScript để gán background-image từ data-setbg -->
<script>
document.querySelectorAll('.set-bg').forEach(element => {
    const bgImage = element.getAttribute('data-setbg');
    if (bgImage) {
        const img = new Image();
        img.src = bgImage;
        img.onload = () => {
            element.style.backgroundImage = `url(${bgImage})`;
            console.log(`Loaded image: ${bgImage}`);
        };
        img.onerror = () => {
            console.error(`Failed to load image: ${bgImage}`);
            element.style.backgroundImage = `url(<?php echo BASE_URL; ?>img/product/default.jpg)`;
        };
    } else {
        console.warn('Missing data-setbg for element:', element);
        element.style.backgroundImage = `url(<?php echo BASE_URL; ?>img/product/default.jpg)`;
    }
});
</script>

<?php include_once BASE_PATH . 'app/views/layout/footer.php'; ?>