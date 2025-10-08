<?php
session_start();
include('includes/dbconnection.php');

$user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;
$session_token = session_id();

// ===== MERGE guest cart nếu user login =====
if ($user_id > 0) {
    mysqli_begin_transaction($con);
    try {
        $stmt_g = $con->prepare("SELECT id, product_id, quantity FROM tbl_cart WHERE user_id = 0 AND session_id = ? AND status = 'active' FOR UPDATE");
        $stmt_g->bind_param("s", $session_token);
        $stmt_g->execute();
        $res_g = $stmt_g->get_result();

        while ($g = $res_g->fetch_assoc()) {
            $prod_id = intval($g['product_id']);
            $qty_guest = intval($g['quantity']);

            $stmt_exist = $con->prepare("SELECT id, quantity FROM tbl_cart WHERE user_id = ? AND product_id = ? AND status = 'active' FOR UPDATE");
            $stmt_exist->bind_param("ii", $user_id, $prod_id);
            $stmt_exist->execute();
            $res_exist = $stmt_exist->get_result();

            if ($res_exist->num_rows > 0) {
                $row_exist = $res_exist->fetch_assoc();
                $new_qty = intval($row_exist['quantity']) + $qty_guest;
                $stmt_up = $con->prepare("UPDATE tbl_cart SET quantity = ?, updated_at = NOW() WHERE id = ?");
                $stmt_up->bind_param("ii", $new_qty, $row_exist['id']);
                $stmt_up->execute();
                $stmt_del = $con->prepare("DELETE FROM tbl_cart WHERE id = ?");
                $stmt_del->bind_param("i", $g['id']);
                $stmt_del->execute();
            } else {
                $stmt_move = $con->prepare("UPDATE tbl_cart SET user_id = ?, session_id = ? , updated_at = NOW() WHERE id = ?");
                $stmt_move->bind_param("isi", $user_id, $session_token, $g['id']);
                $stmt_move->execute();
            }
        }
        mysqli_commit($con);
    } catch (Exception $e) {
        mysqli_rollback($con);
    }
}

// ===== Lấy dữ liệu giỏ hàng =====
if ($user_id > 0) {
    $stmt = $con->prepare("SELECT c.*, p.title, p.img FROM tbl_cart c JOIN tblproduct p ON c.product_id = p.p_id WHERE c.user_id = ? AND c.status = 'active'");
    $stmt->bind_param("i", $user_id);
} else {
    $stmt = $con->prepare("SELECT c.*, p.title, p.img FROM tbl_cart c JOIN tblproduct p ON c.product_id = p.p_id WHERE c.user_id = 0 AND c.session_id = ? AND c.status = 'active'");
    $stmt->bind_param("s", $session_token);
}
$stmt->execute();
$res = $stmt->get_result();

$rows = [];
$total = 0.0;
while ($r = $res->fetch_assoc()) {
    $rows[] = $r;
    $total += $r['quantity'] * $r['unit_price'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: "Poppins", sans-serif;
        }

        .cart-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cart-item h5 {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .price {
            font-size: 1rem;
            font-weight: 500;
            color: #28a745;
        }

        .total-section {
            background: #f1f3f5;
            border-radius: 10px;
            padding: 20px;
        }

        .btn-update {
            background: #0d6efd;
            color: #fff;
            border: none;
            font-size: 0.9rem;
            padding: 6px 14px;
            border-radius: 8px;
        }

        .btn-remove {
            background: #dc3545;
            color: #fff;
            border: none;
            font-size: 0.9rem;
            padding: 6px 14px;
            border-radius: 8px;
        }

        .btn-checkout {
            background: #198754;
            color: #fff;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
        }

        .btn-continue {
            background: #6c757d;
            color: #fff;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="cart-container mx-auto col-lg-10">
            <h3 class="mb-4"><i class="bi bi-cart-fill"></i> Shopping Cart</h3>

            <?php

            // Nếu có thông báo thành công
            if (isset($_SESSION['cart_success'])) {
                echo "<div class='alert alert-success text-center'>" . $_SESSION['cart_success'] . "</div>";
                unset($_SESSION['cart_success']); // xóa ngay sau khi hiển thị
            }

            // Nếu có thông báo lỗi
            if (isset($_SESSION['cart_error'])) {
                echo "<div class='alert alert-danger text-center'>" . $_SESSION['cart_error'] . "</div>";
                unset($_SESSION['cart_error']); // xóa luôn
            }
            ?>
            <?php if (empty($rows)): ?>
                <div class="text-center p-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="150" class="mb-3" alt="Empty cart">
                    <h5>Your cart is empty.</h5>
                    <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
                </div>
            <?php else: ?>
                <?php foreach ($rows as $r): ?>
                    <div class="cart-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="assets/<?php echo htmlspecialchars($r['img']); ?>" alt="">
                            <div class="ms-3">
                                <h5><?php echo htmlspecialchars($r['title']); ?></h5>
                                <div class="price">$<?php echo number_format($r['unit_price'], 2); ?></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <form method="post" action="cart-actions.php" class="d-flex align-items-center">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="cart_id" value="<?php echo $r['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo intval($r['quantity']); ?>" min="1" class="form-control me-2" style="width:80px;">
                                <button class="btn-update me-2" type="submit">Update</button>
                            </form>
                            <form method="post" action="cart-actions.php">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="cart_id" value="<?php echo $r['id']; ?>">
                                <button class="btn-remove" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="total-section mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="m-0">Total: <span class="text-success">$<?php echo number_format($total, 2); ?></span></h5>
                    <div class="d-flex gap-3 mt-2 mt-md-0">
                        <a href="index.php" class="btn-continue">Continue Shopping</a>
                        <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
<script>
setTimeout(() => {
  const alertBox = document.querySelector('.alert');
  if (alertBox) alertBox.style.display = 'none';
}, 3000); // ẩn sau 3 giây
</script>

</html>