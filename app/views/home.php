<?php
include_once __DIR__ . '/layout/header.php';
include_once __DIR__ . '/layout/header_content.php';
?>

<!-- Nội dung trang home -->
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
                        <span>All departments</span>
                    </div>
                    <ul>
                        <!-- Category Group: Lifestyle -->
                        <li><a href="#">Fashion</a></li>
                        <li><a href="#">Footwear</a></li>
                        <li><a href="#">Jewelry & Accessories</a></li>
                        <li><a href="#">Beauty & Personal Care</a></li>
                        <!-- Category Group: Family & Home -->
                        <li><a href="#">Home & Kitchen</a></li>
                        <li><a href="#">Baby & Kids</a></li>
                        <li><a href="#">Pet Supplies</a></li>
                        <!-- Category Group: Essentials -->
                        <li><a href="#">Groceries</a></li>
                        <li><a href="#">Health & Wellness</a></li>
                        <li><a href="#">Books & Stationery</a></li>
                        <!-- Category Group: Tech & Entertainment -->
                        <li><a href="#">Electronics</a></li>
                        <li><a href="#">Toys & Games</a></li>
                        <li><a href="#">Sports & Outdoors</a></li>
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
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>028 2008 1888</h5>
                            <span>Support 24/7 time</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
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
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="img/categories/Fashion.png">
                        <h5><a href="#">Fashion</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="img/categories/Beauty.png">
                        <h5><a href="#">Beauty & Personal Care</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="img/categories/Groceries.png">
                        <h5><a href="#">Groceries</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="img/categories/Book.png">
                        <h5><a href="#">Books & Stationery</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="img/categories/Electronic.png">
                        <h5><a href="#">Electronics</a></h5>
                    </div>
                </div>
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
                    <h2>Featured Product</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".fashion">Fashion</li>
                        <li data-filter=".beauty">Beauty & Personal Care</li>
                        <li data-filter=".groceries">Groceries</li>
                        <li data-filter=".toy">Toys & Games</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <!-- Fashion -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix fashion">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/fashion-1.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">T-shirt</a></h6>
                        <h5>$15.00</h5>
                    </div>
                </div>
            </div>
            <!-- Beauty & Personal Care -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix beauty">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/beauty-1.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Eyeshadow Palette</a></h6>
                        <h5>$25.00</h5>
                    </div>
                </div>
            </div>
            <!-- Groceries -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix groceries">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/groceries-1.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Organic Rice</a></h6>
                        <h5>$9.00</h5>
                    </div>
                </div>
            </div>
            <!-- Toys & Games -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix toy">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/toy-1.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Lego Set</a></h6>
                        <h5>$17.00</h5>
                    </div>
                </div>
            </div>
            <!-- Fashion -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix fashion">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/fashion-2.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Jeans</a></h6>
                        <h5>$19.00</h5>
                    </div>
                </div>
            </div>
            <!-- Beauty & Personal Care -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix beauty">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/beauty-2.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Lipstick</a></h6>
                        <h5>$20.00</h5>
                    </div>
                </div>
            </div>
            <!-- Groceries -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix groceries">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/groceries-2.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Olive Oil</a></h6>
                        <h5>$10.00</h5>
                    </div>
                </div>
            </div>
            <!-- Toys & Games -->
            <div class="col-lg-3 col-md-4 col-sm-6 mix toy">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="img/featured/toy-2.png">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">Board Game</a></h6>
                        <h5>$11.00</h5>
                    </div>
                </div>
            </div>
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
                    <img src="img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-2.jpg" alt="">
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
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/last-1.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Noodles</h6>
                                    <span>$3.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Bell pepper</h6>
                                    <span>$5.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/last-2.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Rice Organic</h6>
                                    <span>$9.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/last-3.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Notebook</h6>
                                    <span>$3.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/milk.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Milk</h6>
                                    <span>$4.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/cest.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Sponge cakey</h6>
                                    <span>$2.50</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Rated Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/beauty-1.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Eyeshadow Palette</h6>
                                    <span>$25.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/beauty-2.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Lipstick</h6>
                                    <span>$20.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/makeup remover.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Makeup remover</h6>
                                    <span>$15.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/mask.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Skin care face mask</h6>
                                    <span>$7.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/watch.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Watch</h6>
                                    <span>$100.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/calcula.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Calculator</h6>
                                    <span>$27.00</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Review Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/flip.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Flip-flops</h6>
                                    <span>$5.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/pen.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Peny</h6>
                                    <span>$1.50</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/clock.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Clock</h6>
                                    <span>$11.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lamp.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Lamp</h6>
                                    <span>$14.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/fan.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Handheld fan</h6>
                                    <span>$18.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/wallet.png" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Wallet</h6>
                                    <span>$22.00</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<?php
include_once __DIR__ . '/layout/footer.php';
?>