<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);

if (isset($_POST['submit'])) {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $contno = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $ret = mysqli_query($con, "select Email from tbluser where Email='$email' || MobileNumber='$contno'");
    $result = mysqli_fetch_array($ret);
    if ($result > 0) {

        echo "<script>alert('This email or Contact Number already associated with another account!.');</script>";
    } else {
        $query = mysqli_query($con, "insert into tbluser(FirstName, LastName, MobileNumber, Email, Password) value('$fname', '$lname','$contno', '$email', '$password' )");
        if ($query) {

            echo "<script>alert('You have successfully registered.');</script>";
            echo '<script>window.location.href=login.php</script>';
        } else {

            echo "<script>alert('Something Went Wrong. Please try again.');</script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>


    <title>Beauty Parlour Management System | Signup Page</title>

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
    <script type="text/javascript">
        function checkpass() {
            if (document.signup.password.value != document.signup.repeatpassword.value) {
                alert('Password and Repeat Password field does not match');
                document.signup.repeatpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <!-- disable body scroll which navbar is in active -->

    <!-- breadcrumbs -->
    <section class="w3l-inner-banner-main">
        <div class="about-inner contact ">
            <div class="container">
                <div class="main-titles-head text-center">
                    <h3 class="header-name ">

                        Signup
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
                        Signup</li>
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
                    <div class="map-content-9 mt-lg-0 mt-4">
                        <h3>Register with us!!</h3>
                        <form method="post" name="signup" onsubmit="return validateForm();">

                            <div style="padding-top: 30px;">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                    placeholder="First Name" required>
                                <small class="error-message" id="firstname-error"></small>
                            </div>

                            <div style="padding-top: 30px;">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname"
                                    placeholder="Last Name" required>
                                <small class="error-message" id="lastname-error"></small>
                            </div>

                            <div style="padding-top: 30px;">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobilenumber" id="mobilenumber"
                                    placeholder="Mobile Number" required maxlength="10">
                                <small class="error-message" id="mobile-error"></small>
                            </div>

                            <div style="padding-top: 30px;">
                                <label>Email address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email address" required>
                                <small class="error-message" id="email-error"></small>
                            </div>

                            <div style="padding-top: 30px;">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password" required>
                                <small class="error-message" id="password-error"></small>
                            </div>

                            <div style="padding-top: 30px;">
                                <label>Repeat password</label>
                                <input type="password" class="form-control" name="repeatpassword" id="repeatpassword"
                                    placeholder="Repeat password" required>
                                <small class="error-message" id="repeatpassword-error"></small>
                            </div>

                            <button type="submit" class="btn btn-contact" name="submit">Signup</button>
                        </form>
                    </div>
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

    <style>
        .error-message {
            color: red;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
    </style>

    <script>
        function validateForm() {
            let valid = true;

            // Reset error messages
            document.querySelectorAll(".error-message").forEach(el => el.innerText = "");

            // First Name
            const firstname = document.getElementById("firstname").value.trim();
            if (firstname.length < 10) {
                document.getElementById("firstname-error").innerText = "First name must be at least 10 characters.";
                valid = false;
            }

            // Last Name
            const lastname = document.getElementById("lastname").value.trim();
            if (lastname.length < 10) {
                document.getElementById("lastname-error").innerText = "Last name must be at least 10 characters.";
                valid = false;
            }

            // Mobile Number
            const mobile = document.getElementById("mobilenumber").value.trim();
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobile)) {
                document.getElementById("mobile-error").innerText = "Mobile number must be exactly 10 digits.";
                valid = false;
            }

            // Email (must be Gmail)
            const email = document.getElementById("email").value.trim();
            const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!gmailRegex.test(email)) {
                document.getElementById("email-error").innerText = "Email must be a valid Gmail address.";
                valid = false;
            }

            // Password
            const password = document.getElementById("password").value;
            if (password.length === 0) {
                document.getElementById("password-error").innerText = "Password cannot be empty.";
                valid = false;
            }

            // Repeat Password
            const repeatPassword = document.getElementById("repeatpassword").value;
            if (repeatPassword !== password) {
                document.getElementById("repeatpassword-error").innerText = "Passwords do not match.";
                valid = false;
            }

            return valid;
        }
    </script>
    <!-- /move top -->
</body>

</html>