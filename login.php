

<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $emailcon = $_POST['emailcont'];
    $password = md5($_POST['password']); // ⚠️ Dùng MD5 giống lúc đăng ký

    // Truy vấn kiểm tra user
    $query = mysqli_query($con, "SELECT ID FROM tbluser WHERE (Email='$emailcon' OR MobileNumber='$emailcon') AND Password='$password'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['bpmsuid'] = $row['ID']; // ✅ Lưu ID user vào session
        header('location:index.php'); // ✅ Chuyển sang trang chủ
        exit();
    } else {
        echo "<script>alert('Invalid Details.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>


    <title>Beauty Parlour Management System | Login</title>

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

                        Login Page
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
                        Login</li>
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
                                <span class="fa fa-phone text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Call Us</h6>
                                <p class="para"><a href="tel:+44 99 555 42">+<?php echo $row['MobileNumber']; ?></a></p>
                            </div>
                        </div>
                        <div class="cont-top margin-up">
                            <div class="cont-left text-center">
                                <span class="fa fa-envelope-o text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Email Us</h6>
                                <p class="para"><a href="mailto:example@mail.com"
                                        class="mail"><?php echo $row['Email']; ?></a></p>
                            </div>
                        </div>
                        <div class="cont-top margin-up">
                            <div class="cont-left text-center">
                                <span class="fa fa-map-marker text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Address</h6>
                                <p class="para"> <?php echo $row['PageDescription']; ?></p>
                            </div>
                        </div>
                        <div class="cont-top margin-up">
                            <div class="cont-left text-center">
                                <span class="fa fa-map-marker text-primary"></span>
                            </div>
                            <div class="cont-right">
                                <h6>Time</h6>
                                <p class="para"> <?php echo $row['Timing']; ?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <form method="post" id="loginForm" novalidate>
                        <div>
                            <input type="text" class="form-control" name="emailcont" id="emailcont"
                                placeholder="Registered Email or Contact Number" required>
                            <div id="emailError" class="error-message"></div>
                        </div>

                        <div style="padding-top: 20px;">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password" required>
                            <div id="passwordError" class="error-message"></div>
                        </div>

                        <div class="twice-two" style="padding-top: 20px;">
                            <a class="link--gray" style="color: blue;" href="forgot-password.php">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-contact" name="login">Login</button>
                    </form>

                </div>

            </div>
        </div>
    </section>
    <?php include_once('includes/footer.php'); ?>
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-long-arrow-up"></span>
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
    <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        let emailcont = document.getElementById('emailcont').value.trim();
        let password = document.getElementById('password').value.trim();
        let emailError = document.getElementById('emailError');
        let passwordError = document.getElementById('passwordError');
        let valid = true;

        // Reset lỗi
        emailError.textContent = '';
        passwordError.textContent = '';

        // Regex
        let gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        let phonePattern = /^[0-9]{10}$/;

        // Kiểm tra email hoặc số điện thoại
        if (!gmailPattern.test(emailcont) && !phonePattern.test(emailcont)) {
            emailError.textContent = 'Vui lòng nhập Gmail hợp lệ hoặc số điện thoại 10 số';
            valid = false;
        }

        // Kiểm tra password
        if (password.length < 6) {
            passwordError.textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
            valid = false;
        }

        if (!valid) {
            e.preventDefault(); // Ngăn submit nếu có lỗi
        }
    });
    </script>

    <style>
    /* Form Container */
    .map-content-9 form {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Input style */
    .map-content-9 input.form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px 15px;
        font-size: 15px;
        transition: 0.3s;
    }

    .map-content-9 input.form-control:focus {
        border-color: #ff4081;
        box-shadow: 0 0 5px rgba(255, 64, 129, 0.3);
        outline: none;
    }

    /* Button */
    .btn.btn-contact {
        width: 100%;
        background: linear-gradient(45deg, #ff4081, #ff80ab);
        color: #fff;
        padding: 12px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        margin-top: 20px;
        transition: 0.3s;
    }

    .btn.btn-contact:hover {
        background: linear-gradient(45deg, #ff80ab, #ff4081);
        transform: translateY(-1px);
    }

    /* Error message */
    .error-message {
        color: red;
        font-size: 13px;
        margin-top: 5px;
    }
    </style>

    <!-- /move top -->
</body>

</html>