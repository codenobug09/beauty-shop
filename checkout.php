<?php
session_start();
include('includes/dbconnection.php');

$user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;
if ($user_id == 0) {
    $_SESSION['cart_error'] = "You must login to checkout.";
    header("Location: cart.php");
    exit;
}

// Lấy giỏ hàng hiện tại
$stmt_cart = $con->prepare("
    SELECT c.*, p.title, p.price 
    FROM tbl_cart c 
    JOIN tblproduct p ON c.product_id = p.p_id 
    WHERE c.user_id = ? AND c.status = 'active'
");
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$res_cart = $stmt_cart->get_result();

if ($res_cart->num_rows === 0) {
    $_SESSION['cart_error'] = "Your cart is empty.";
    header("Location: cart.php");
    exit;
}

$cart_items = [];
$total_order = 0.0;
while ($row = $res_cart->fetch_assoc()) {
    $cart_items[] = $row;
    $total_order += $row['quantity'] * $row['unit_price'];
}

// Xử lý submit form checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_address = trim($_POST['shipping_address']);
    $payment_method = trim($_POST['payment_method']);

    if (empty($shipping_address) || empty($payment_method)) {
        $_SESSION['cart_error'] = "Please fill in all required fields.";
        header("Location: checkout.php");
        exit;
    }

    mysqli_begin_transaction($con);

    try {
        // 1. Tạo order
        $stmt_order = $con->prepare("
            INSERT INTO tblorders (user_id, status, total, shipping_address, payment_method, created_at, updated_at)
            VALUES (?, 'pending', ?, ?, ?, NOW(), NOW())
        ");
        $stmt_order->bind_param("idss", $user_id, $total_order, $shipping_address, $payment_method);
        $stmt_order->execute();
        $order_id = $con->insert_id;

        // 2. Tạo order_details
        $stmt_detail = $con->prepare("
            INSERT INTO tbl_order_details (order_id, product_id, quantity, unit_price, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())
        ");
        foreach ($cart_items as $item) {
            $stmt_detail->bind_param(
                "iiid",
                $order_id,
                $item['product_id'],
                $item['quantity'],
                $item['unit_price']
            );
            $stmt_detail->execute();
        }

        // 3. Xóa giỏ hàng
        $stmt_del_cart = $con->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
        $stmt_del_cart->bind_param("i", $user_id);
        $stmt_del_cart->execute();

        mysqli_commit($con);

        $_SESSION['cart_success'] = "Checkout successful! Your order ID is #" . $order_id;
        header("Location: order_success.php?order_id=" . $order_id);
        exit;

    } catch (Exception $e) {
        mysqli_rollback($con);
        $_SESSION['cart_error'] = "Checkout failed: " . $e->getMessage();
        header("Location: checkout.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h3>Checkout</h3>

    <?php
    if (isset($_SESSION['cart_error'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['cart_error'] . "</div>";
        unset($_SESSION['cart_error']);
    }
    ?>

    <form method="post" action="checkout.php">
        <div class="mb-3">
            <label for="shipping_address" class="form-label">Shipping Address</label>
            <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="">Select method</option>
                <option value="COD">Cash on Delivery (COD)</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Paypal">Paypal</option>
            </select>
        </div>

        <h5 class="mt-4">Order Summary</h5>
        <ul class="list-group mb-3">
            <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($item['title']); ?> x <?php echo intval($item['quantity']); ?>
                    <span>$<?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></span>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item d-flex justify-content-between">
                <strong>Total</strong>
                <strong>$<?php echo number_format($total_order, 2); ?></strong>
            </li>
        </ul>

        <button type="submit" class="btn btn-success">Place Order</button>
    </form>
</div>
</body>
</html>
