<?php
// Current page URL path
$current_page = basename($_SERVER['REQUEST_URI'], ".php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">


    <!-- Css Styles -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/style.css" type="text/css">

    <style>
        .my_bg {
            /* background: url('../assets/images/banner_1.webp') no-repeat center center/cover; */
            width: 100% !;
            /* height: 125vh; */
            height: auto;
        }

        .navbar_shadow {
            width: 100%;
            /* border: 1px solid red; */
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }

        @media only screen and (max-width: 767px) {
            .my_bg {

                width: 100%;
                /* height: 50%; */
                /* background-size:cont; */
                background-position: center;
            }
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <!-- <div id="preloder">
            <div class="loader"></div>
        </div> -->


    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">


        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><i class="fa-solid fa-magnifying-glass"></i></a>
            <a href="#"><i class="fa-regular fa-heart"></i></a>
            <a href="#"><i class="fa-solid fa-bag-shopping"></i></a>
            <div class="price">0</div>
        </div>
    </div>
    <!-- Offcanvas Menu End -->


    <!-- Header Section Begin -->
    <header class="header my_bg ">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-7">
                        <div class="header__top__left">
                            <p>50% Off and Free Shipping All Over Pakistan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar_shadow">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="header__logo">
                            <a href="./index.html"><img src="./assets/images/logo_bw.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="<?= ($current_page == 'index') ? 'active' : ''; ?>"><a
                                        href="./index.php">Home</a></li>
                                <li class="<?= ($current_page == 'shop') ? 'active' : ''; ?>"><a
                                        href="./shop.php">Shop</a></li>
                                <li
                                    class="<?= ($current_page == 'bouquets' || $current_page == 'boxes' || $current_page == 'occasions') ? 'active' : ''; ?>">
                                    <a>Category</a>
                                    <ul class="dropdown">
                                        <li class="<?= ($current_page == 'bouquets') ? 'active' : ''; ?>"><a
                                                href="./bouquets.php">Bouquets</a></li>
                                        <li class="<?= ($current_page == 'boxes') ? 'active' : ''; ?>"><a
                                                href="./boxes.php">Boxes</a></li>
                                        <li class="<?= ($current_page == 'occasions') ? 'active' : ''; ?>"><a
                                                href="./occasions.php">Occasions</a></li>
                                    </ul>
                                </li>
                                <li class="<?= ($current_page == 'about') ? 'active' : ''; ?>"><a
                                        href="./about.php">About</a></li>
                                <li class="<?= ($current_page == 'contact') ? 'active' : ''; ?>"><a
                                        href="./contact.php">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="header__nav__option">
                            <!-- <a href="#" class="search-switch"><i class="fa-solid fa-magnifying-glass"></i></a>
                            <a href="#"><i class="fa-regular fa-heart"></i></a>
                            <a href="#"><i class="fa-solid fa-bag-shopping"></i></a> -->

                            <a href="#" class="search-switch"><i class="mdi mdi-magnify"></i></a>
                            <a href="#"><i class="mdi mdi-heart-outline"></i></a>
                            <a href="#"><i class="mdi mdi-shopping-outline"></i></a>

                        </div>
                    </div>
                </div>
                <div class="canvas__open"><i class="fa fa-bars"></i></div>
            </div>
        </div>
    </header>


    <!-- Header Section End -->

    
<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">


</body>

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

<!-- Js Plugins -->
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.nice-select.min.js"></script>
<script src="../assets/js/jquery.nicescroll.min.js"></script>
<script src="../assets/js/jquery.magnific-popup.min.js"></script>
<script src="../assets/js/jquery.countdown.min.js"></script>
<script src="../assets/js/jquery.slicknav.js"></script>
<script src="../assets/js/mixitup.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/frontent_main.js"></script>

</html>