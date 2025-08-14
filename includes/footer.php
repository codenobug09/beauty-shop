<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<section class="w3l-footer-29-main">
  <div class="footer-29 py-5">
    <div class="container py-lg-4">
      <div class="row footer-top-29">
        <div class="col-lg-3 col-md-6 col-sm-8 footer-list-29 footer-1">
          <h6 class="footer-title-29">Contact Us</h6>
          <ul>
            <?php

            $ret = mysqli_query($con, "select * from tblpage where PageType='contactus' ");
            $cnt = 1;
            while ($row = mysqli_fetch_array($ret)) {

            ?>
              <li>
                <span class="fa fa-map-marker"></span>
                <p><?php echo $row['PageDescription']; ?>.</p>
              </li>
              <li><span class="fa fa-phone"></span><a href="tel:+7-800-999-800">
                  +<?php echo $row['MobileNumber']; ?></a></li>
              <li><span class="fa fa-envelope-open-o"></span><a href="mailto:parlour@mail.com" class="mail">
                  <?php echo $row['Email']; ?></a></li><?php } ?>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-4 footer-list-29 footer-2 ">

          <ul>
            <h6 class="footer-title-29">Useful Links</h6>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php"> Services</a></li>
            <li><a href="contact.php">Contact us</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-4 footer-list-29 footer-2 ">

          <ul>
            <h6 class="footer-title-29">Buy Comestics</h6>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php"> Services</a></li>
            <li><a href="contact.php">Contact us</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-7 footer-list-29 footer-4">
          <?php

          $ret = mysqli_query($con, "select * from tblpage where PageType='aboutus' ");
          $cnt = 1;
          while ($row = mysqli_fetch_array($ret)) {

          ?>
            <h6 class="footer-title-29"><?php echo $row['PageTitle'];
                                      } ?> </h6>
            <p>Our main focus is on quality and hygiene. Our Parlour is well equipped with advanced technology
              equipments and provides best quality services. Our staff is well trained and experienced,
              offering advanced services in Skin, Hair and Body Shaping that will provide you with a luxurious
              experience that leave you feeling relaxed and stress free.</p>

        </div>
      </div>
    </div>
  </div>
</section>
<section class="w3l-footer-29-main w3l-copyright">
  <div class="container">
    <div class="row bottom-copies">
      <p class="col-lg-8 copy-footer-29"> Beauty Parlour Management System </p>

      <div class="col-lg-4 main-social-footer-29">
        <a href="#facebook" class="facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#twitter" class="twitter"><i class="fa-brands fa-twitter"></i></a>
        <a href="#instagram" class="instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="#linkedin" class="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>

      </div>

    </div>
  </div>
</section>

<style>
  /* Footer tổng thể */
  .w3l-footer-29-main {
    background: linear-gradient(135deg, #2c2c2c, #1b1b1b);
    color: #f0f0f0;
    font-family: 'Segoe UI', sans-serif;
  }

  /* Padding & khoảng cách */
  .footer-29 {
    padding: 60px 0;
  }

  .footer-title-29 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #ff9eb5;
    position: relative;
  }

  .footer-title-29::after {
    content: "";
    display: block;
    width: 40px;
    height: 2px;
    background: #ff9eb5;
    margin-top: 8px;
  }

  /* Danh sách footer */
  .footer-list-29 ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-list-29 ul li {
    margin-bottom: 12px;
    display: flex;
    align-items: center;
  }

  .footer-list-29 ul li a {
    color: #ccc;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .footer-list-29 ul li a:hover {
    color: #ff9eb5;
  }

  /* Icon trong footer */
  .footer-list-29 span.fa {
    font-size: 16px;
    color: #ff9eb5;
    margin-right: 10px;
  }

  /* About text */
  .footer-list-29 p {
    margin: 0;
    color: #bbb;
    line-height: 1.6;
  }

  /* Social links */
  .main-social-footer-29 a {
    display: inline-block;
    margin-right: 10px;
    background: #ff9eb5;
    color: #1b1b1b;
    width: 35px;
    height: 35px;
    text-align: center;
    line-height: 35px;
    border-radius: 50%;
    transition: background 0.3s ease, transform 0.3s ease;
  }

  .main-social-footer-29 a:hover {
    background: #ff6f91;
    transform: translateY(-3px);
  }

  /* Copyright section */
  .w3l-copyright {
    background: #141414;
    padding: 15px 0;
    font-size: 0.9rem;
    color: #aaa;
  }

  .copy-footer-29 {
    margin: 0;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .footer-top-29 {
      text-align: center;
    }

    .footer-list-29 ul li {
      justify-content: center;
    }

    .main-social-footer-29 {
      margin-top: 15px;
      text-align: center;
    }
  }
</style>