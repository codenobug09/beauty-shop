<!-- Font Awesome để có icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<section class="w3l-header-4 header-sticky">
    <header class="absolute-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <h1>
                    <a class="navbar-brand" href="index.php">
                        <i class="fa-solid fa-scissors"></i> BPMS
                    </a>
                </h1>

                <button class="navbar-toggler bg-gradient collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="fa icon-expand fa-bars"></span>
                    <span class="fa icon-close fa-times"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i> Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="about.php"><i class="fa-solid fa-info-circle"></i> About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="services.php"><i class="fa-solid fa-hand-sparkles"></i>
                                Services</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="product.php"><i class="fa-solid fa-envelope"></i>Beauty Product</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="featureMenu" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-bars-staggered"></i> Features
                            </a>
                            <div class="dropdown-menu" aria-labelledby="featureMenu">

                                <?php if (strlen($_SESSION['bpmsuid'] == 0)) { ?>
                                    <a class="dropdown-item" href="admin/index.php"><i class="fa-solid fa-user-shield"></i>
                                        Admin</a>
                                    <a class="dropdown-item" href="signup.php"><i class="fa-solid fa-user-plus"></i>
                                        Signup</a>
                                    <a class="dropdown-item" href="login.php"><i class="fa-solid fa-right-to-bracket"></i>
                                        Login</a>
                                <?php } else { ?>
                                    <a class="dropdown-item" href="book-appointment.php"><i
                                            class="fa-solid fa-calendar-check"></i> Book Salon</a>
                                    <a class="dropdown-item" href="order.php"><i
                                            class="fa-solid fa-calendar-check"></i>Order</a>
                                    <a class="dropdown-item" href="cart.php"><i
                                            class="fa fa-cart-plus"></i>Cart</a>
                                    <a class="dropdown-item" href="booking-history.php"><i
                                            class="fa-solid fa-clock-rotate-left"></i> Booking History</a>
                                    <a class="dropdown-item" href="invoice-history.php"><i
                                            class="fa-solid fa-file-invoice"></i> Invoice History</a>
                                    <a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
                                    <a class="dropdown-item" href="change-password.php"><i class="fa-solid fa-gear"></i>
                                        Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="logout.php"><i
                                            class="fa-solid fa-right-from-bracket"></i> Logout</a>
                                <?php } ?>

                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </header>
</section>

<style>
    /* ===== Header Styles ===== */
    .w3l-header-4 {
        font-family: 'Segoe UI', sans-serif;
    }

    .w3l-header-4 header {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: background 0.3s ease, box-shadow 0.3s ease;
        z-index: 999;
    }

    /* Sticky effect */
    .w3l-header-4.header-sticky header.sticky {
        background: #fff;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }

    /* Logo */
    .navbar-brand {
        font-size: 1.8rem;
        font-weight: 700;
        color: #ff4f81 !important;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    .navbar-brand:hover {
        color: #ff007f !important;
    }

    /* Ẩn caret (mũi tên) trong Bootstrap dropdown-toggle */
    .dropdown-toggle::after {
        display: none !important;
    }

    /* Menu links */
    .navbar-nav .nav-link {
        color: #333;
        font-weight: 500;
        padding: 10px 15px;
        position: relative;
        transition: color 0.3s ease;
        margin-left: 30px;
    }

    .navbar-nav .nav-link i {
        margin-right: 6px;
        color: #ff4f81;
    }

    .navbar-nav .nav-link:hover {
        color: #ff4f81;
    }

    /* Hover underline animation */
    .navbar-nav .nav-link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 5px;
        width: 0%;
        height: 2px;
        background: #ff4f81;
        transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after {
        width: 100%;
    }

    /* Dropdown */
    .dropdown-menu {
        border-radius: 8px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        padding: 10px 15px;
        transition: background 0.2s ease;
    }

    .dropdown-item i {
        margin-right: 8px;
        color: #ff4f81;
    }

    .dropdown-item:hover {
        background: #ffe6ef;
        color: #ff4f81;
    }

    /* Toggle button (mobile) */
    .navbar-toggler {
        border: none;
        outline: none;
        padding: 5px 10px;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .icon-expand,
    .icon-close {
        font-size: 1.3rem;
        color: #ff4f81;
    }

    /* Responsive fix */
    @media (max-width: 991px) {
        .navbar-nav {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .navbar-nav .nav-link {
            padding: 8px 10px;
        }
    }
</style>