<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">

<head>


  <title>Beauty Parlour Management System | service Page </title>

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
    <div class="about-inner services ">
      <div class="container">
        <div class="main-titles-head text-center">
          <h3 class="header-name ">
            Our Service
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
          <li class="active ">Services</li>
        </ul>
      </div>
    </div>
    </div>
  </section>
  <!-- breadcrumbs //-->
  <section class="w3l-recent-work-hobbies">
    <div class="recent-work ">
      <div class="container">
        <div class="row about-about">
          <?php


          $ret = mysqli_query($con, "select * from  tblservices");
          $cnt = 1;
          while ($row = mysqli_fetch_array($ret)) {

          ?>
            <div class="col-lg-4 col-md-6 col-sm-6 propClone">
              <img src="admin/images/<?php echo $row['Image'] ?>" alt="product" height="200" width="400"
                class="img-responsive about-me">
              <div class="about-grids ">
                <hr>
                <h5 class="para"><?php echo $row['ServiceName']; ?></h5>
                <p class="para "><?php echo $row['ServiceDescription']; ?> </p>
                <p class="para " style="color: hotpink;"> Cost of Service: $<?php echo $row['Cost']; ?> </p>

              </div>
            </div>
            <br><?php
                $cnt = $cnt + 1;
              } ?>

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
  <!-- /move top -->
  <style>
    /* Nền và font chữ */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff9fc;
      color: #333;
    }

    /* Tiêu đề Our Service */
    .header-name {
      font-size: 36px;
      font-weight: bold;
      color: #ff4d6d;
      position: relative;
      display: inline-block;
    }

    .header-name::after {
      content: "";
      display: block;
      width: 60px;
      height: 3px;
      background: #ff4d6d;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    /* Khung dịch vụ */
    .about-about .col-lg-4 {
      margin-bottom: 30px;
    }

    .about-grids {
      background: white;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      transition: all 0.4s ease;
      box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.08);
      min-height: 200px;
    }

    /* Ảnh dịch vụ */
    .about-about img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 12px;
      transition: transform 0.4s ease;
    }

    /* Hover card */
    .col-lg-4:hover img {
      transform: scale(1.05);
    }

    .col-lg-4:hover .about-grids {
      transform: translateY(-8px);
      box-shadow: 0px 12px 25px rgba(255, 77, 109, 0.25);
    }

    /* Tên dịch vụ */
    .about-grids h5 {
      font-size: 20px;
      font-weight: bold;
      margin-top: 15px;
      color: #ff4d6d;
    }

    /* Mô tả dịch vụ */
    .about-grids p {
      font-size: 14px;
      color: #666;
      margin-bottom: 8px;
    }

    /* Giá dịch vụ */
    .about-grids p[style*="color: hotpink"] {
      font-weight: bold;
      font-size: 16px;
      color: #ff4d6d !important;
    }

    /* Breadcrumb đẹp hơn */
    .breadcrumbs-sub {
      background: #fff0f5;
      padding: 10px 0;
    }

    .breadcrumbs-custom-path li {
      display: inline-block;
      font-size: 14px;
    }

    .breadcrumbs-custom-path a {
      color: #ff4d6d;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .breadcrumbs-custom-path a:hover {
      color: #ff1a4c;
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
</body>

</html>