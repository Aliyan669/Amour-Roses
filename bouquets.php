<?php
include "./includes/db.php";


$all_bouquets = "SELECT 
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
    p.product_category_id = c.cate_id
WHERE 
    c.cate_name = 'Bouquets';
";

$bouquets_result = $conn->query($all_bouquets);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Roses | Bouquets</title>
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">

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

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Bouquets</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <span>Bouquets</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->


    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">

                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="#">Rs.50.00 - Rs.200</a></li>
                                                    <li><a href="#">Rs.200 - Rs.500</a></li>
                                                    <li><a href="#">Rs.500 - Rs.1000</a></li>
                                                    <li><a href="#">Rs.1000 - Rs.1500</a></li>
                                                    <li><a href="#">Rs.1500 - Rs.2000</a></li>
                                                    <li><a href="#">Rs.2000+</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                    </div>
                                    <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__size">
                                                <label for="sm">s
                                                    <input type="radio" id="sm">
                                                </label>
                                                <label for="md">m
                                                    <input type="radio" id="md">
                                                </label>
                                                <label for="l">l
                                                    <input type="radio" id="l">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                                    </div>
                                    <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__color">
                                                <label class="c-1" for="sp-1">
                                                    <input type="radio" id="sp-1">
                                                </label>
                                                <label class="c-8" for="sp-8">
                                                    <input type="radio" id="sp-8">
                                                </label>
                                                <label class="c-9" for="sp-9">
                                                    <input type="radio" id="sp-9">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                    </div>
                                    <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__tags">
                                                <a href="#">Fashion</a>
                                                <a href="#">New Arrival</a>
                                                <a href="#">Flower</a>
                                                <a href="#">Bouquets</a>
                                                <a href="#">Birthday</a>
                                                <a href="#">Gifts</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1–12 of 12 results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select>
                                        <option value="">Low to High</option>
                                        <option value="">High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if ($bouquets_result->num_rows > 0) {
                            while ($row = $bouquets_result->fetch_assoc()) {
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-6  mix">
                                    <div class="product__item sale">
                                        <div class="product__item__pic set-bg"
                                            onclick="location.href='product.php?id=<?= $row['product_id']; ?>'"
                                            style="cursor: pointer;"
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
                            echo "<p class='text-center'>No products found in 'Bouquets' category.</p>";
                        }
                        ?>

                    </div>

                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                <a class="active" href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <span>...</span>
                                <a href="#">21</a>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->


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