<?php
include_once __DIR__ . '../layout/header.php';
include_once __DIR__ . '../layout/header_content.php';
require_once '../database/config.php';

// 1. Nhận ID sản phẩm
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nếu ID không hợp lệ
if ($id <= 0) {
    echo "<h2 style='color:red; text-align:center;'>ID sản phẩm không hợp lệ!</h2>";
    include_once __DIR__ . '/../layout/footer.php';
    exit;
}

// 2. Lấy chi tiết sản phẩm + ảnh đại diện
$sql = "SELECT p.*, pi.image_path, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.thumbnail = b'1'
        WHERE p.product_id = :id";
$productStmt = $conn->prepare($sql);
$productStmt->bindParam(':id', $id, PDO::PARAM_INT);
$productStmt->execute();
$product = $productStmt->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy sản phẩm
if (!$product) {
    echo "<h2 style='text-align:center; color:red;'>Sản phẩm không tồn tại hoặc đã bị xóa!</h2>";
    include_once __DIR__ . '/../layout/footer.php';
    exit;
}

// 3. Lấy danh mục
$stmt = $conn->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. Lấy gallery ảnh phụ
$galleryStmt = $conn->prepare("SELECT image_path FROM product_images WHERE product_id = :id AND thumbnail = b'0' ORDER BY display_order ASC");
$galleryStmt->bindParam(':id', $id, PDO::PARAM_INT);
$galleryStmt->execute();
$galleryImages = $galleryStmt->fetchAll(PDO::FETCH_ASSOC);

// 5. Xử lý đường dẫn ảnh sản phẩm chính
$imageLarge = (!empty($product['image_path'])) ? $product['image_path'] : 'img/product/default.jpg';
?>

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <li><a href="#"><?php echo htmlspecialchars($category['category_name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do you need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon"><i class="fa fa-phone"></i></div>
                        <div class="hero__search__phone__text">
                            <h5>+84 90 636 4541</h5>
                            <span>Support 24/7 Time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2><?php echo htmlspecialchars($product['name_product']); ?></h2>
                    <div class="breadcrumb__option">
                        <a href="/Final%20Project_Group07%20(22_4_2025)/public/?page=index">Home</a>
                        <a href="#"><?php echo htmlspecialchars($product['category_name'] ?? 'Category'); ?></a>
                        <span><?php echo htmlspecialchars($product['name_product']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Details Section -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" 
                             src="/Final%20Project_Group07%20(22_4_2025)/public/<?php echo htmlspecialchars($imageLarge); ?>" 
                             alt="">
                    </div>
                    <div class="product__details__pic__slider owl-carousel">
                        <?php foreach ($galleryImages as $img): ?>
                            <?php
                            $galleryImage = (!empty($img['image_path'])) ? $img['image_path'] : 'img/product/default.jpg';
                            ?>
                            <img data-imgbigurl="/Final%20Project_Group07%20(22_4_2025)/public/<?php echo htmlspecialchars($galleryImage); ?>"
                                 src="/Final%20Project_Group07%20(22_4_2025)/public/<?php echo htmlspecialchars($galleryImage); ?>" alt="">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3><?php echo htmlspecialchars($product['name_product']); ?></h3>
                    <div class="product__details__rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>
                        <span>(18 reviews)</span>
                    </div>
                    <div class="product__details__price">$<?php echo number_format($product['price'], 2); ?></div>
                    <p><?php echo nl2br(htmlspecialchars($product['description'] ?? 'Mô tả không có')); ?></p>
                    <div class="product__details__quantity">
                        <div class="quantity">
                            <div class="pro-qty"><input type="text" value="1"></div>
                        </div>
                    </div>
                    <a href="#" class="primary-btn">ADD TO CART</a>
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <ul>
                        <li><b>Availability</b> <span><?php echo htmlspecialchars($product['stock_quantity'] ?? 0); ?> in stock</span></li>
                        <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                        <li><b>Weight</b> <span><?php echo htmlspecialchars($product['weight'] ?? 'N/A'); ?> kg</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-product">
    <div class="container">
        <div class="section-title related__product__title"><h2>Related Product</h2></div>
        <div class="row">
            <?php
            $relatedStmt = $conn->query(
                "SELECT p.*, pi.image_path 
                 FROM products p
                 LEFT JOIN product_images pi ON p.product_id = pi.product_id AND pi.thumbnail = b'1'
                 LIMIT 4"
            );
            while ($relatedProduct = $relatedStmt->fetch(PDO::FETCH_ASSOC)): 
                $relatedImage = (!empty($relatedProduct['image_path'])) ? $relatedProduct['image_path'] : 'img/product/default.jpg';
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                    <div class="product__item__pic">
                        <img src="/Final%20Project_Group07%20(22_4_2025)/public/<?php echo htmlspecialchars($relatedImage); ?>" alt="Related Product Image">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                        <div class="product__item__text">
                            <h6><a href="/Final%20Project_Group07%20(22_4_2025)/public/?page=shop_detail&id=<?php echo $relatedProduct['product_id']; ?>">
                                <?php echo htmlspecialchars($relatedProduct['name_product']); ?>
                            </a></h6>
                            <h5>$<?php echo number_format($relatedProduct['price'], 2); ?></h5>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '../layout/footer.php'; ?>
