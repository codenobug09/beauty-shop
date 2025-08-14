<?php
session_start();
error_reporting(0);
include('../bpms/includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us | Beauty Parlour Management System</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css" />
    <link rel="stylesheet" href="./style.css" />
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />
</head>

<body>
    <!-- Header -->
    <?php include_once('../bpms/includes/header.php'); ?>

    <section class="w3l-services-block py-5">
        <div class="container py-lg-4">
            <div class="text-center mb-5">
                <h3 class="title-big">Dịch Vụ Nổi Bật</h3>
                <p class="para">Mang đến trải nghiệm làm đẹp toàn diện từ mái tóc, làn da đến đôi bàn tay của bạn.</p>
            </div>
            <div class="row">

                <!-- Cắt, tạo kiểu & chăm sóc tóc -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card p-4 h-100 shadow-sm rounded">
                        <img src="assets\images\11.jpg" alt="Cắt, tạo kiểu & chăm sóc tóc"
                            class="img-fluid mb-3 rounded">
                        <h4 class="mb-3">Cắt, Tạo Kiểu & Chăm Sóc Tóc</h4>
                        <p>Đội ngũ chuyên gia tạo kiểu tóc sẽ giúp bạn tìm ra phong cách phù hợp nhất, từ cắt tỉa gọn
                            gàng, tạo kiểu thời trang cho đến dưỡng tóc chuyên sâu để mái tóc luôn óng mượt và khỏe
                            mạnh.</p>
                    </div>
                </div>

                <!-- Nhuộm, highlight & phục hồi tóc -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card p-4 h-100 shadow-sm rounded">
                        <img src="assets\images\12.jpg" alt="Nhuộm, highlight & phục hồi tóc"
                            class="img-fluid mb-3 rounded">
                        <h4 class="mb-3">Nhuộm, Highlight & Phục Hồi Tóc</h4>
                        <p>Biến hóa diện mạo với màu nhuộm thời thượng, highlight bắt mắt. Kết hợp cùng liệu trình phục
                            hồi chuyên sâu để tóc vừa đẹp vừa khỏe.</p>
                    </div>
                </div>

                <!-- Chăm sóc móng -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card p-4 h-100 shadow-sm rounded">
                        <img src="assets\images\12.jpg" alt="Chăm sóc móng" class="img-fluid mb-3 rounded">
                        <h4 class="mb-3">Chăm Sóc Móng – Manicure & Pedicure</h4>
                        <p>Tận hưởng dịch vụ làm móng chuyên nghiệp, từ cắt tỉa, tạo hình, sơn gel đến trang trí nghệ
                            thuật. Đảm bảo đôi tay, đôi chân của bạn luôn mềm mại và quyến rũ.</p>
                    </div>
                </div>

                <!-- Massage thư giãn -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card p-4 h-100 shadow-sm rounded">
                        <img src="assets\images\12.jpg" alt="Massage thư giãn & chăm sóc da mặt"
                            class="img-fluid mb-3 rounded">
                        <h4 class="mb-3">Massage Thư Giãn & Chăm Sóc Da Mặt</h4>
                        <p>Giúp cơ thể thả lỏng, xua tan căng thẳng với liệu pháp massage chuyên nghiệp. Kết hợp chăm
                            sóc da mặt bằng sản phẩm cao cấp để da luôn tươi trẻ, mịn màng.</p>
                    </div>
                </div>

                <!-- Tẩy lông & chăm sóc da -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card p-4 h-100 shadow-sm rounded">
                        <img src="assets\images\12.jpg" alt="Tẩy lông & chăm sóc da toàn thân"
                            class="img-fluid mb-3 rounded">
                        <h4 class="mb-3">Tẩy Lông & Chăm Sóc Da Toàn Thân</h4>
                        <p>Dịch vụ tẩy lông nhẹ nhàng, an toàn và nhanh chóng. Kết hợp với chăm sóc da toàn thân để làn
                            da mịn màng, trắng sáng và đầy sức sống.</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Khung iframe video -->
        <div class="container mt-5">
            <div class="row align-items-center">

                <!-- Video bên trái -->
                <div class="col-lg-7 col-md-12 mb-4 mb-lg-0">
                    <div class="video-wrapper">
                        <iframe width="100%" height="400" src="https://www.youtube.com/embed/UG8JxlDEgp8"
                            title="Video làm đẹp" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Content bên phải -->
                <div class="col-lg-5 col-md-12">
                    <h3 class="mb-3">Giới Thiệu Về Dịch Vụ</h3>
                    <p>
                        Chúng tôi tự hào mang đến trải nghiệm làm đẹp toàn diện, từ mái tóc, làn da cho đến đôi bàn tay
                        của bạn.
                        Với đội ngũ chuyên gia giàu kinh nghiệm, trang thiết bị hiện đại và sản phẩm cao cấp, mỗi dịch
                        vụ đều được
                        thiết kế để mang lại sự hài lòng tuyệt đối.
                    </p>
                    <ul class="list-unstyled">
                        <li>💇‍♀️ Cắt, tạo kiểu & chăm sóc tóc</li>
                        <li>🎨 Nhuộm, highlight & phục hồi tóc</li>
                        <li>💅 Chăm sóc móng chuyên nghiệp</li>
                        <li>💆‍♀️ Massage thư giãn & chăm sóc da</li>
                    </ul>
                    <a href="book-appointment.php" class="btn logo-button mt-3">Đặt Lịch Ngay</a>
                </div>

            </div>
        </div>

    </section>


    <!-- Footer -->
    <?php include_once('../bpms/includes/footer.php'); ?>

    <!-- Move Top Button -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-long-arrow-up"></span>
    </button>

    <!-- JS Scripts -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
    window.onscroll = function() {
        document.getElementById("movetop").style.display =
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20 ?
            "block" :
            "none";
    };

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    </script>
</body>

</html>