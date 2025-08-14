<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $query = mysqli_query($con, "insert into tblcontact(FirstName,LastName,Phone,Email,Message) value('$fname','$lname','$phone','$email','$message')");
    if ($query) {
        echo "<script>alert('Your message was sent successfully!.');</script>";
        echo "<script>window.location.href ='contact.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>
<!doctype html>
<html lang="en">

<head>


    <title>Beauty Parlour Management System | Contact us Page</title>

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
        <div class="about-inner contact ">
            <div class="container">
                <div class="main-titles-head text-center">
                    <h3 class="header-name ">

                        Contact Us
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
                    <li class="active ">
                        Contact</li>
                </ul>
            </div>
        </div>
        </div>
    </section>
    <!-- breadcrumbs //-->
    <section class="w3l-contact-info-main" id="contact">
        <div class="contact-sec	">
            <div class="container">

                <div class="d-grid contact-view">
                    <div class="cont-details">
                        <?php

                        $ret = mysqli_query($con, "select * from tblpage where PageType='contactus' ");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($ret)) {

                        ?>
                            <div class="cont-top">
                                <div class="cont-left text-center">
                                    <span class="fa fa-phone text-primary small-icon"></span>
                                </div>
                                <div class="cont-right">
                                    <h6>Call Us</h6>
                                    <p class="para"><a href="tel:+44 99 555 42">+<?php echo $row['MobileNumber']; ?></a></p>
                                </div>
                            </div>
                            <div class="cont-top margin-up">
                                <div class="cont-left text-center">
                                    <span class="fa fa-envelope-o text-primary small-icon"></span>
                                </div>
                                <div class="cont-right">
                                    <h6>Email Us</h6>
                                    <p class="para"><a href="mailto:example@mail.com"
                                            class="mail"><?php echo $row['Email']; ?></a></p>
                                </div>
                            </div>
                            <div class="cont-top margin-up">
                                <div class="cont-left text-center">
                                    <span class="fa fa-map-marker text-primary small-icon"></span>
                                </div>
                                <div class="cont-right">
                                    <h6>Address</h6>
                                    <p class="para"> <?php echo $row['PageDescription']; ?></p>
                                </div>
                            </div>
                            <div class="cont-top margin-up">
                                <div class="cont-left text-center">
                                    <span class="fa fa-clock-o text-primary small-icon"></span>
                                </div>
                                <div class="cont-right">
                                    <h6>Time</h6>
                                    <p class="para"> <?php echo $row['Timing']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="map-content-9 mt-lg-0 mt-4">
                        <form method="post">
                            <div class="twice-two">
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name"
                                    required="">
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name"
                                    required="">
                            </div>
                            <div class="twice-two">
                                <input type="text" class="form-control" placeholder="Phone" required="" name="phone"
                                    pattern="[0-9]+" maxlength="10">
                                <input type="email" class="form-control" class="form-control" placeholder="Email"
                                    required="" name="email">
                            </div>

                            <textarea class="form-control" id="message" name="message" placeholder="Message"
                                required=""></textarea>
                            <button type="submit" class="btn btn-contact" name="submit">Send Message</button>
                        </form>
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
        /* ===== Reset & Base ===== */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h3.header-name {
            font-weight: 700;
            font-size: 2.5rem;
            text-transform: uppercase;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ===== Breadcrumbs ===== */
        .breadcrumbs-sub {
            background: #f0f0f0;
            padding: 10px 0;
        }

        .breadcrumbs-custom-path {
            list-style: none;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #666;
        }

        .breadcrumbs-custom-path li {
            margin-right: 10px;
        }

        .breadcrumbs-custom-path li.active {
            font-weight: bold;
            color: #c2185b;
        }

        .breadcrumbs-custom-path li a:hover {
            color: #c2185b;
        }

        /* ===== Contact Section ===== */
        .w3l-contact-info-main {
            padding: 60px 0;
        }

        .d-grid.contact-view {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 30px;
        }

        .cont-details {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .cont-top {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .cont-left {
            background: #c2185b;
            color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .small-icon {
            font-size: 10px;
        }

        .cont-right {
            margin-left: 20px
        }

        .cont-right h6 {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .cont-right .para a {
            color: #555;
        }

        .cont-right .para a:hover {
            color: #c2185b;
        }

        /* ===== Contact Form ===== */
        .map-content-9 {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .map-content-9 input,
        .map-content-9 textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .map-content-9 input:focus,
        .map-content-9 textarea:focus {
            border-color: #c2185b;
            box-shadow: 0 0 8px rgba(194, 24, 91, 0.3);
            outline: none;
        }

        .twice-two {
            display: flex;
            gap: 15px;
        }

        .btn-contact {
            background: #c2185b;
            color: #fff;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-contact:hover {
            background: #a0154b;
            transform: translateY(-2px);
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .d-grid.contact-view {
                grid-template-columns: 1fr;
            }

            .twice-two {
                flex-direction: column;
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