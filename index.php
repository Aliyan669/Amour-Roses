<!-- https://houseofflowers.pk/collections/bouquets -->
<!-- https://www.blossomsflorals.com/celebration-central.html -->

<?php
include "./includes/db.php";


$bouquets = "SELECT * FROM category WHERE cate_name = 'Bouquets' ";
$bouquets_result = $conn->query($bouquets);


$boxes = "SELECT * FROM category WHERE cate_name = 'Boxes' ";
$boxes_result = $conn->query($boxes);

$occasions = "SELECT * FROM category WHERE cate_name = 'Occasions' ";
$occasions_result = $conn->query($occasions);

$best_seller = "SELECT 
    p.product_id, 
    p.product_name, 
    p.product_sku, 
    p.product_description, 
    p.product_price, 
    p.product_image_1, 
    p.product_image_2, 
    p.datetime, 
    c.cate_name, 
    c.cate_description
FROM 
    products p
JOIN 
    category c 
ON 
    p.promotion_category_id = c.cate_id
WHERE 
    c.cate_name = 'Best Seller';
";

$best_result = $conn->query($best_seller);

$new_arrival = "SELECT 
    p.product_id, 
    p.product_name, 
    p.product_sku, 
    p.product_description, 
    p.product_price, 
    p.product_image_1, 
    p.product_image_2, 
    p.datetime, 
    c.cate_name, 
    c.cate_description
FROM 
    products p
JOIN 
    category c 
ON 
    p.promotion_category_id = c.cate_id
WHERE 
    c.cate_name = 'New Arrival';
";

$new_result = $conn->query($new_arrival);



$deal = "SELECT 
    p.product_id, 
    p.product_name, 
    p.product_sku, 
    p.product_description, 
    p.product_price, 
    p.product_image_1, 
    p.product_image_2, 
    p.datetime, 
    c.cate_name, 
    c.cate_description
FROM 
    products p
JOIN 
    category c 
ON 
    p.promotion_category_id = c.cate_id
WHERE 
    c.cate_name = 'Deal';
";

$deal_result = $conn->query($deal);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Roses</title>
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">


    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">


    <!-- Css Styles -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css">

    <style>
        .banner_image {
            margin-bottom: 40px;
        }

        /* .my_bg {
            background: url('./assets/images/banner_1.webp') no-repeat center center/cover;
            width: 100%;
            height: 125vh !important;
            margin-bottom: 40px
        } */

        /* .navbar_shadow {
            width: 100%;
            border: 1px solid red;
            box-shadow: none !important;
        } */

        /* @media only screen and (max-width: 479px) {

            .my_bg {

                width: 100% !important;
                height: 70vh !important;

                background-size: contain  ;          
            }
        } */
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <?php
    include "./includes/header.php"
        ?>

    <div>
        <img class="banner_image" src="./assets/images/banner_1.jpg" />
    </div>

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li>Best Sellers</li>
                        <!-- <li data-filter="">New Arrivals</li>
                        <li data-filter=".hot-sales">Hot Sales</li> -->
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                <?php
                if ($best_result->num_rows > 0) {
                    while ($row = $best_result->fetch_assoc()) {
                        ?>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix">
                            <div class="product__item sale">

                                <div class="product__item__pic set-bg "
                                    data-setbg="./assets/images/product_image/<?= $row['product_image_1'] ?>"
                                    onclick="location.href='product.php?id=<?= $row['product_id']; ?>'"
                                    style="cursor: pointer;">
                                    <span class="label">Sale</span>
                                    <ul class="product__hover">
                                        <li><a href="#"><i class="fa-regular fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                                    </ul>
                                </div>

                                <div class="product__item__text">
                                    <h6><?php echo $row['product_name']; ?></h6>
                                    <a href="#" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </div>
                                    <h5>Rs.<?php echo $row['product_price']; ?></h5>
                                    <div class="product__color__select">
                                        <label class="active" for="pc-">
                                            <input type="radio" id="pc-7">
                                        </label>
                                        <label class="black" for="pc-8">
                                            <input type="radio" id="pc-8">
                                        </label>
                                        <label class="grey" for="pc-9">
                                            <input type="radio" id="pc-9">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No products found in 'Best Seller' category.</p>";
                }
                ?>

            </div>
        </div>
    </section>
    <!-- Product Section End -->


    <!-- Category Callection Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <?php
                if ($bouquets_result->num_rows > 0) {
                    $bouquets_row = mysqli_fetch_assoc($bouquets_result)
                        ?>
                    <div class="col-lg-7 offset-lg-4">
                        <div class="banner__item">
                            <div class="banner__item__pic">
                                <img src="./assets/images/cate_image/<?= $bouquets_row['cate_image'] ?>" alt="">
                            </div>
                            <div class="banner__item__text">
                                <h2><?php echo $bouquets_row['cate_name'] ?> </h2>
                                <a href="bouquets.php">Shop now</a>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>

                <?php
                if ($boxes_result->num_rows > 0) {
                    $boxes_row = mysqli_fetch_assoc($boxes_result)
                        ?>
                    <div class="col-lg-5">
                        <div class="banner__item banner__item--middle">
                            <div class="banner__item__pic">
                                <img src="./assets/images/cate_image/<?= $boxes_row['cate_image'] ?>">
                            </div>
                            <div class="banner__item__text">
                                <h2><?php echo $boxes_row['cate_name'] ?></h2>
                                <a href="boxes.php">Shop now</a>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>


                <?php
                if ($occasions_result->num_rows > 0) {
                    $occasions_row = mysqli_fetch_assoc($occasions_result)
                        ?>
                    <div class="col-lg-7">
                        <div class="banner__item banner__item--last">
                            <div class="banner__item__pic">
                                <img src="./assets/images/cate_image/<?= $occasions_row['cate_image'] ?>">

                            </div>
                            <div class="banner__item__text">
                                <h2><?php echo $occasions_row['cate_name'] ?></h2>
                                <a href="occasions.php">Shop now</a>
                            </div>
                        </div>
                    </div>

                    <?php
                }

                ?>

            </div>
        </div>
    </section>
    <!-- Category Callection Section End -->

    <!-- New Arrival Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li>New Arrival</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                <?php
                if ($new_result->num_rows > 0) {
                    while ($row = $new_result->fetch_assoc()) {
                        ?>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix">
                            <div class="product__item sale">
                                <div class="product__item__pic set-bg"
                                    onclick="location.href='product.php?id=<?= $row['product_id']; ?>'" style="cursor: pointer;"
                                    data-setbg="./assets/images/product_image/<?= $row['product_image_1'] ?>">
                                    <span class="label">Sale</span>
                                    <ul class="product__hover">
                                        <li><a href="#"><i class="fa-regular fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><?php echo $row['product_name']; ?></h6>
                                    <a href="#" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </div>
                                    <h5>Rs.<?php echo $row['product_price']; ?></h5>
                                    <div class="product__color__select">
                                        <label class="active" for="pc-7">
                                            <input type="radio" id="pc-7">
                                        </label>
                                        <label class="black" for="pc-8">
                                            <input type="radio" id="pc-8">
                                        </label>
                                        <label class="grey" for="pc-9">
                                            <input type="radio" id="pc-9">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No products found in 'New Arrival' category.</p>";
                }
                ?>

            </div>
        </div>
    </section>
    <!-- New Arrival Product Section End -->


    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <!-- <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div> -->
                <?php
                if ($deal_result->num_rows > 0) {
                    $deal_row = mysqli_fetch_assoc($deal_result)
                        ?>

                    <div class="col-lg-4 offset-lg-1">
                        <div class="categories__hot__deal">
                            <img src="./assets/images/product_image/<?= $deal_row['product_image_1'] ?>" alt="">
                            <div class="hot__deal__sticker">
                                <span>Sale Of</span>
                                <h5>Rs. <?php echo $deal_row['product_price']; ?></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 offset-lg-1">
                        <div class="categories__deal__countdown">
                            <span>Deal Of The Week</span>
                            <h2><?php echo $deal_row['product_name']; ?></h2>
                            <div class="categories__deal__countdown__timer" id="countdown">
                                <div class="cd-item">
                                    <span>3</span>
                                    <p>Days</p>
                                </div>
                                <div class="cd-item">
                                    <span>1</span>
                                    <p>Hours</p>
                                </div>
                                <div class="cd-item">
                                    <span>50</span>
                                    <p>Minutes</p>
                                </div>
                                <div class="cd-item">
                                    <span>18</span>
                                    <p>Seconds</p>
                                </div>
                            </div>
                            <a href="product.php?id=<?= $deal_row['product_id']; ?>" class="primary-btn">Shop now</a>
                        </div>
                    </div>

                    <?php
                }

                ?>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->



    <!-- <h1>This is Flower Website</h1> -->


    <?php
    include "./includes/footer.php"
        ?>
</body>
<!-- Js Plugins -->
<script src="./assets/js/jquery-3.3.1.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.nicescroll.min.js"></script>
<script src="./assets/js/jquery.magnific-popup.min.js"></script>
<script src="./assets/js/jquery.countdown.min.js"></script>
<script src="./assets/js/jquery.slicknav.js"></script>
<script src="./assets/js/mixitup.min.js"></script>
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/frontent_main.js"></script>

</html>