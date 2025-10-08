<!DOCTYPE html>
<html lang="en">
<?php
include("includes/dbconnection.php");
error_reporting(0);
session_start();

include_once 'includes/header.php';

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Beauty Parlour Management System | Product Page</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="css_add_more/bootstrap.min.css" rel="stylesheet">
    <link href="css_add_more/font-awesome.min.css" rel="stylesheet">
    <link href="css_add_more/animsition.min.css" rel="stylesheet">
    <link href="css_add_more/animate.css" rel="stylesheet">
    <link href="css_add_more/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


<body>

    <body id="home">
        <?php include_once('includes/header.php'); ?>

        <script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
        <!--bootstrap working-->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- //bootstrap working-->
        <!-- disable body scroll which navbar is in active -->
        <script>
            $(function() {
                $('.navbar-toggler').click(function() {
                    $('body').toggleClass('noscroll');
                })
            });
        </script>
        <!-- disable body scroll which navbar is in active -->

        <!-- breadcrumbs -->
        <section class="w3l-inner-banner-main">
            <div class="about-inner about ">
                <div class="container">
                    <div class="main-titles-head text-center">
                        <h3 class="header-name ">
                            Product Beauty
                        </h3>
                    </div>
                </div>
            </div>
            <div class="breadcrumbs-sub">
                <div class="container">
                    <ul class="breadcrumbs-custom-path">
                        <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right"
                                    aria-hidden="true"></span></a>
                            <p>
                        </li>
                        <li class="active">Product Beauty</li>
                    </ul>
                </div>
            </div>
            </div>
        </section>
        <!-- breadcrumbs //-->
        <section class="popular">
            <div class="container">
                <div class="title text-xs-center m-b-30">
                    <h2>Product</h2>
                    <p class="lead">Easiest way to order your favourite food among these top 6 dishes</p>
                </div>
                <div class="row">
                    <?php
                    $query_res = mysqli_query($con, "select * from tblproduct");
                    while ($r = mysqli_fetch_array($query_res)) {

                        echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                                            <div class="food-item-wrap">
                                                <div class="figure-wrap bg-image" data-image-src="assets/'. $r['img'].'"></div>
                                                <div class="content">
                                                    <h5><a href="dishes.php?res_id=' . $r['p_id'] . '">' . $r['title'] . '</a></h5>
                                                    <div class="product-name">' . $r['slogan'] . '</div>
                                                    <div class="price-btn-block"> <span class="price">$' . $r['price'] . '</span> <a href="order-product.php?product_id=' . $r['p_id'] . '" class="btn theme-btn-dash pull-right">Order Now</a> </div>
                                                </div>
                                                
                                            </div>
                                    </div>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php include_once('includes/footer.php'); ?>
        <!-- move top -->
        <button onclick="topFunction()" id="movetop" title="Go to top">
            <span style="transform: translate(-2.5px, -4px)" class="fa fa-long-arrow-up"></span>
        </button>
        <script>
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {
                scrollFunction()
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("movetop").style.display = "block";
                } else {
                    document.getElementById("movetop").style.display = "none";
                }
            }

            // When the user clicks on the button, scroll to the top of the document
            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>
        <style>
            /* Reset cơ bản */
            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p {
                margin: 0;
                padding: 0;
                font-family: 'Poppins', sans-serif;
            }

            /* Toàn bộ nền và chữ */
            body {
                background: #f9f9f9;
                color: #333;
                line-height: 1.6;
            }

            /* Tiêu đề chính */
            h3.header-name {
                font-size: 40px;
                font-weight: bold;
                color: #ff4081;
                margin-bottom: 15px;
            }

            /* Breadcrumb */
            .breadcrumbs-sub {
                background: #fff;
                padding: 12px 0;
                border-bottom: 1px solid #eee;
            }

            .breadcrumbs-custom-path li {
                display: inline;
                font-size: 15px;
            }

            .breadcrumbs-custom-path li a {
                color: #ff4081;
                text-decoration: none;
                font-weight: 500;
            }

            .breadcrumbs-custom-path li.active {
                color: #555;
            }

            /* About section */
            .w3l-content-with-photo-4 {
                padding: 50px 0;
            }

            .cwp4-image img {
                border-radius: 15px;
                box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            }

            .cwp4-text h3 {
                color: #ff4081;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .hair-two-colums {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .hair-left {
                background: #fff;
                padding: 10px 15px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease;
            }

            .hair-left:hover {
                transform: translateY(-5px);
                background: #ffebf2;
            }

            /* Recent work */
            .w3l-recent-work {
                background: linear-gradient(135deg, #fff, #ffe6f0);
                padding: 60px 0;
            }

            .hair-make h5 {
                font-size: 26px;
                font-weight: bold;
                color: #ff4081;
            }

            .hair-make p {
                margin-top: 10px;
                font-size: 15px;
                color: #555;
            }

            .my-bio {
                padding-right: 30px;
            }

            .my-bio p {
                line-height: 1.8;
            }

            .col-lg-6 img {
                border-radius: 15px;
                box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
            }

            /* Animation mượt */
            img {
                transition: transform 0.4s ease, box-shadow 0.4s ease;
            }

            img:hover {
                transform: scale(1.02);
                box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .hair-two-colums {
                    flex-direction: column;
                }

                .my-bio {
                    padding-right: 0;
                }
            }

            #movetop {
                background: #ff4d6d;
                border: none;
                padding: 10px 14px;
                border-radius: 50%;
                color: white;
                cursor: pointer;
                box-shadow: 0 4px 10px rgba(255, 77, 109, 0.4);
                transition: all 0.3s ease;
            }

            #movetop:hover {
                background: #ff1a4c
            }

            /* =====================
   Product Section Style
   ===================== */

            .popular {
                padding: 60px 0;
                background: #f9f9f9;
                font-family: 'Poppins', sans-serif;
            }

            .popular .title h2 {
                font-weight: 600;
                font-size: 2.2rem;
                margin-bottom: 10px;
                color: #333;
            }

            .popular .title p {
                color: #777;
                font-size: 1rem;
                margin-bottom: 40px;
            }

            /* Product Card */
            .food-item {
                margin-bottom: 30px;
            }

            .food-item-wrap {
                background: #fff;
                border-radius: 15px;
                overflow: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            }

            .food-item-wrap:hover {
                transform: translateY(-8px);
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
            }

            /* Image */
            .figure-wrap {
                position: relative;
                width: 100%;
                height: 230px;
                background-size: cover;
                background-position: center;
                border-bottom: 1px solid #eee;
            }

            /* Content */
            .food-item-wrap .content {
                padding: 20px;
                text-align: center;
            }

            .food-item-wrap h5 {
                font-size: 1.1rem;
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
            }

            .food-item-wrap h5 a {
                text-decoration: none;
                color: #333;
                transition: color 0.3s;
            }

            .food-item-wrap h5 a:hover {
                color: #e74c3c;
            }

            .food-item-wrap .product-name {
                color: #888;
                font-size: 0.95rem;
                margin-bottom: 12px;
            }

            /* Price and Button */
            .price-btn-block {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .price-btn-block .price {
                font-size: 1.1rem;
                font-weight: 600;
                color: #e74c3c;
            }

            .theme-btn-dash {
                background: none;
                border: 1.5px solid #e74c3c;
                color: #e74c3c;
                padding: 6px 15px;
                border-radius: 20px;
                transition: all 0.3s ease;
                font-size: 0.9rem;
            }

            .theme-btn-dash:hover {
                background: #e74c3c;
                color: #fff;
            }

            /* Responsive */
            @media (max-width: 767px) {
                .food-item-wrap .content {
                    padding: 15px;
                }

                .price-btn-block {
                    flex-direction: column;
                    gap: 10px;
                }
            }
        </style>
        <script src="js_more/jquery.min.js"></script>
        <script src="js_more/tether.min.js"></script>
        <script src="js_more/bootstrap.min.js"></script>
        <script src="js_more/animsition.min.js"></script>
        <script src="js_more/bootstrap-slider.min.js"></script>
        <script src="js_more/jquery.isotope.min.js"></script>
        <script src="js_more/headroom.js"></script>
        <script src="js_more/foodpicky.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll(".bg-image").forEach(el => {
                    const src = el.getAttribute("data-image-src");
                    if (src) el.style.backgroundImage = `url(${src})`;
                });
            });
        </script>

        <!-- /move top -->
    </body>
</body>

</html>