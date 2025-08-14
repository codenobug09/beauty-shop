<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">

<head>

    <title>Beauty Parlour Management System | About us Page</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

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
                        About Us
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
                    <li class="active ">About</li>
                </ul>
            </div>
        </div>
        </div>
    </section>
    <!-- breadcrumbs //-->
    <section class="w3l-content-with-photo-4" id="about">
        <div class="content-with-photo4-block ">
            <div class="container">
                <div class="cwp4-two row">
                    <div class="cwp4-image col-xl-6">
                        <img src="assets/images/b2.jpg" alt="product" class="img-responsive about-me">
                    </div>
                    <div class="cwp4-text col-xl-6 ">
                        <div class="posivtion-grid">
                            <h3 class="">Beauty and success starts here</h3>
                            <div class="hair-two-colums">
                                <div class="hair-left">
                                    <h5>
                                        Waxing</h5>
                                </div>
                                <div class="hair-left">
                                    <h5>Facial</h5>
                                </div>
                                <div class="hair-left">
                                    <h5>Hair makeup</h5>

                                </div>
                                <div class="hair-left">
                                    <h5>Massage</h5>

                                </div>
                                <div class="hair-left">
                                    <h5>Menicure</h5>
                                </div>

                                <div class="hair-left">
                                    <h5>Pedicure</h5>
                                </div>
                                <div class="hair-left">
                                    <h5>Hair Cut</h5>
                                </div>

                                <div class="hair-left">
                                    <h5>Body Spa</h5>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w3l-recent-work">
        <div class="jst-two-col">
            <div class="container">
                <div class="row">
                    <div class="my-bio col-lg-6">

                        <div class="hair-make">
                            <?php

                            $ret = mysqli_query($con, "select * from tblpage where PageType='aboutus' ");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($ret)) {

                            ?>
                                <h5><a href="blog.html"><?php echo $row['PageTitle']; ?></a></h5>
                                <p class="para mt-2"><?php echo $row['PageDescription']; ?></p><?php } ?>
                        </div>


                    </div>
                    <div class="col-lg-6 ">
                        <img src="assets/images/b3.jpg" alt="product" class="img-responsive about-me">
                    </div>

                </div>
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
    </style>
    <!-- /move top -->
</body>

</html>