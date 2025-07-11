<?php
include "./includes/db.php";


// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // SQL query to fetch product details
    $sql = "SELECT 
                p.product_id, 
                p.product_name, 
                p.product_sku, 
                p.product_description, 
                p.product_price, 
                p.product_image_1, 
                p.product_image_2, 
                p.datetime, 
                c.cate_name 
            FROM 
                products p
            JOIN 
                category c 
            ON 
                p.product_category_id = c.cate_id
            WHERE 
                p.product_id = $product_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found.");
    }
} else {
    die("Invalid product ID.");
}




$related_product = "SELECT 
product_id, 
product_name, 
product_sku, 
product_description, 
product_price, 
product_image_1, 
product_image_2
FROM 
products ";

$related_result = $conn->query($related_product);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Roses | Product</title>
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css">


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


</head>

<body>
    <?php
    include "./includes/header.php"
        ?>

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="./index.php">Home</a>
                            <a href="./shop.php">Shop</a>
                            <span>Product Details</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div class="product__thumb__pic set-bg"
                                        data-setbg="./assets/images/product_image/<?= $product['product_image_1'] ?>">
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                                    <div class="product__thumb__pic set-bg"
                                        data-setbg="./assets/images/product_image/<?= $product['product_image_2'] ?>">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="./assets/images/product_image/<?= $product['product_image_1'] ?>" alt="">
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="./assets/images/product_image/<?= $product['product_image_2'] ?>" alt="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4><?php echo $product['product_name']; ?></h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            <h3>Rs.<?php echo $product['product_price']; ?><span>Rs.5599</span></h3>
                            <p><?php echo $product['product_description']; ?></p>
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    <label for="sm">S
                                        <input type="radio" id="sm">
                                    </label>
                                    <label for="md">M
                                        <input type="radio" id="md">
                                    </label>

                                    <label for="l">L
                                        <input type="radio" id="l">
                                    </label>

                                </div>
                                <div class="product__details__option__color">
                                    <span>Color:</span>
                                    <label class="c-1" for="sp-1">
                                        <input type="radio" id="sp-1">
                                    </label>
                                    <label class="c-4" for="sp-4">
                                        <input type="radio" id="sp-4">
                                    </label>
                                    <label class="c-9" for="sp-9">
                                        <input type="radio" id="sp-9">
                                    </label>
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                                <a href="#" class="primary-btn atc_btn">add to cart</a>
                                <a href="checkout.php?id=<?= $product_id; ?>" class="primary-btn ">Buy Now</a>
                            </div>
                            <div class="product__details__btns__option">
                                <a href="#"><i class="fa fa-heart"></i> add to wishlist</a>
                                <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Guaranteed Safe Checkout</span></h5>
                                <img width="350px" src="./assets/images/payment.png" alt="">
                                <ul>
                                    <li><span>SKU:</span> <?php echo $product['product_sku']; ?></li>
                                    <li><span>Categories:</span> <?php echo $product['cate_name']; ?></li>
                                    <li><span>Tag:</span> Flower, Wedding, Fashion</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Product
                                        Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                        Previews(4)</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            <p>A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                                a touchscreen and touchpad.</p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                                $350.00, a new Pocket PC can now be purchased.</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                                worn all year round.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <span>Hammad Malik. </span>
                                            <span class="rating my_rating ">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <span> - (4/5) Reviews</span>
                                            </span>

                                            <p>Amour Roses has the most elegant floral arrangements I’ve ever seen. The
                                                bouquet I ordered was fresh, vibrant, and beautifully crafted. Their
                                                service was prompt and professional. Highly recommend for any special
                                                occasion!</p>

                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <span>Yasir Khan. </span>
                                            <span class="rating my_rating ">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <span> - (5/5) Reviews</span>
                                            </span>
                                            <p>I got a flower box for my mom’s birthday, and it was perfect! The flowers
                                                were fresh, and the packaging was so luxurious. Amour Roses really knows
                                                how to make someone feel special. Will definitely order again!</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <span>Iqra Aziz. </span>
                                            <span class="rating my_rating ">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <span> - (3/5) Reviews</span>
                                            </span>
                                            <p>I ordered an anniversary bouquet, and it exceeded my expectations. The
                                                flowers were arranged with such care and attention to detail. Delivery
                                                was quick, and everything was perfect. Amour Roses is my go-to for
                                                flowers now!</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <span>Osama Malik. </span>
                                            <span class="rating my_rating ">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <span> - (5/5) Reviews</span>
                                            </span>
                                            <p>The flowers from Amour Roses were absolutely stunning! They lasted for
                                                days and still looked fresh. The entire process, from ordering to
                                                delivery, was seamless. Perfect for any celebration!</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->


    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li>Related Products</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">

                <?php
                if ($related_result->num_rows > 0) {
                    while ($row = $related_result->fetch_assoc()) {
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
                                        <label for="pc-7">
                                            <input type="radio" id="pc-7">
                                        </label>
                                        <label class="active black" for="pc-8">
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
    <br><br> <br>
    <!-- Product Section End -->

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