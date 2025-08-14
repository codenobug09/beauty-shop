<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>
<!doctype html>
<html lang="en">

<head>

  <title>Beauty Parlour Management System | Home Page</title>

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

  <div class="w3l-hero-headers-9">
    <div class="css-slider">
      <input id="slide-1" type="radio" name="slides" checked>
      <section class="slide slide-one">
        <div class="container">
          <div class="banner-text">
            <h4>Creative Styling</h4>
            <h3>beauty salon<br>
              fashion for woman</h3>

            <a href="book-appointment.php" class="btn logo-button top-margin">Get An Appointment</a>
          </div>
        </div>

      </section>
      <input id="slide-2" type="radio" name="slides">
      <section class="slide slide-two">
        <div class="container">
          <div class="banner-text">
            <h4>Creative Styling</h4>
            <h3>beauty salon<br>
              fashion for woman</h3>
            <a href="book-appointment.php" class="btn logo-button top-margin">Get An Appointment</a>
          </div>
        </div>
        <!-- <nav>
        <label for="slide-2" class="prev">&#10094;</label>
        <label for="slide-1" class="next">&#10095;</label>
      </nav> -->
      </section>
      <header>
        <label for="slide-1" id="slide-1"></label>
        <label for="slide-2" id="slide-2"></label>
      </header>
    </div>
  </div>
  <section class="w3l-call-to-action_9">
    <div class="call-w3 ">
      <div class="container">
        <div class="grids">
          <div class="grids-content row">

            <div class="column col-lg-4 col-md-6 color-2 ">
              <div>
                <h4 class=" ">Our Salon is Most Popular</h4>
                <p class="para ">Eline Hair and Beauty Salon Offers - Beauty Services</p>
                <a href="about.php" class="action-button btn mt-md-4 mt-3">Read more</a>
              </div>
            </div>
            <div class="column col-lg-4 col-md-6 col-sm-6 back-image  ">
              <img src="assets/images/5.jpg" alt="product" class="img-responsive ">
            </div>
            <div class="column col-lg-4 col-md-6 col-sm-6 back-image2 ">
              <img src="assets/images/6.jpg" alt="product" class="img-responsive ">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="w3l-teams-15">
    <div class="team-single-main ">
      <div class="container">

        <div class="column2 image-text">
          <h3 class="team-head ">Come experience the secrets of relaxation</h3>
          <p class="para  text ">
            Best Beauty expert at your home and provides beauty salon at home. Home Salon provide well
            trained beauty professionals for beauty services at home including Facial, Clean Up, Bleach,
            Waxing,Pedicure, Manicure, etc.</p>
          <a href="book-appointment.php" class="btn logo-button top-margin mt-4">Get An Appointment</a>
        </div>
      </div>
    </div>
    </div>
  </section>
  <section class="w3l-specification-6">
    <div class="specification-layout ">
      <div class="container">
        <div class=" row">
          <div class="col-lg-6 back-image">
            <img src="assets/images/b1.jpg" alt="product" class="img-responsive ">
          </div>
          <div class="col-lg-6 about-right-faq align-self">
            <h3 class="title-big"><a href="about_us.php">Clean and Recommended Hair Salon</a></h3>
            <p class="mt-3 para"> Their array of beauty parlour services include haircuts, hair spas,
              colouring, texturing, styling, waxing, pedicures, manicures, threading, body spa, natural
              facials and more.</p>
            <div class="hair-cut">
              <div>
                <ul class="w3l-right-book">
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Hair
                      cut with Blow dry</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Color
                      & highlights</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a
                      href="about_us.php">Shampoo & Set</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Blow
                      Dry & Curl</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a
                      href="about_us.php">Advance Hair Color</a></li>
                </ul>
              </div>
              <div class="image-right">
                <ul class="w3l-right-book">
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Back
                      Massage</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Hair
                      Treatment</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Face
                      Massage</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Skin
                      Care</a></li>
                  <li><span class="fa fa-check" aria-hidden="true"></span><a href="about_us.php">Body
                      Therapies</a></li>
                </ul>
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
    .navbar a {
      color: #444;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #ff4081;
    }

    /* ===== HERO SLIDER ===== */
    .w3l-hero-headers-9 .banner-text {
      padding: 25px;
      border-radius: 12px;
      max-width: 450px;
      backdrop-filter: blur(4px);
    }

    .banner-text h3 {
      color: #ff4081;
      font-weight: bold;
    }

    .btn.logo-button {
      background: linear-gradient(45deg, #ff4081, #ff80ab);
      color: #fff !important;
      padding: 10px 20px;
      border-radius: 25px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn.logo-button:hover {
      background: linear-gradient(45deg, #ff80ab, #ff4081);
      transform: translateY(-2px);
    }

    /* ===== CALL TO ACTION ===== */
    .w3l-call-to-action_9 .column {
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .w3l-call-to-action_9 .column:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .w3l-call-to-action_9 img {
      border-radius: 12px;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* ===== SPECIFICATION & SERVICE SECTION ===== */
    .specification-layout .row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
    }

    .specification-layout img {
      border-radius: 12px;
      max-width: 100%;
    }

    .about-right-faq {
      background: #fff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    /* ===== EQUAL HEIGHT for Service / Feature Cards ===== */
    .row.about-about {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .row.about-about>div {
      display: flex;
      flex-direction: column;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      padding: 15px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .row.about-about>div:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .row.about-about img {
      border-radius: 12px;
      height: 200px;
      object-fit: cover;
      width: 100%;
    }

    .row.about-about h5 {
      margin-top: 15px;
      font-weight: 600;
      color: #ff4081;
    }

    .row.about-about p {
      flex-grow: 1;
      color: #555;
    }

    /* ===== FOOTER ===== */
    footer {
      background-color: #2d2d2d;
      color: #fff;
      padding: 30px 0;
    }

    footer a {
      color: #ff80ab;
      text-decoration: none;
    }

    footer a:hover {
      color: #fff;
    }

    /* Nút scroll lên top */
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