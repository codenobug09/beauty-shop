<?php
session_start();
include('includes/dbconnection.php');

$user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;
if ($user_id == 0) {
    $_SESSION['cart_error'] = "You must login to checkout.";
    header("Location: cart.php");
    exit;
}

// 🔹 Lấy thông tin user
$stmt_user = $con->prepare("SELECT FirstName, email, address FROM tbluser WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user = $stmt_user->get_result()->fetch_assoc();

// 🔹 Lấy giỏ hàng
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

// 🔹 Xử lý submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address_option = $_POST['address_option'];
    $shipping_address = ($address_option === 'new') 
        ? trim($_POST['shipping_address_new'])
        : trim($_POST['shipping_address_old']);

    $payment_method = trim($_POST['payment_method']);

    if (empty($shipping_address) || empty($payment_method)) {
        $_SESSION['cart_error'] = "Please fill in all required fields.";
        header("Location: checkout.php");
        exit;
    }

    mysqli_begin_transaction($con);

    try {
        // 1️⃣ Tạo đơn hàng
        $stmt_order = $con->prepare("
            INSERT INTO tblorders (user_id, status, total, shipping_address, payment_method, created_at, updated_at)
            VALUES (?, 'pending', ?, ?, ?, NOW(), NOW())
        ");
        $stmt_order->bind_param("idss", $user_id, $total_order, $shipping_address, $payment_method);
        $stmt_order->execute();
        $order_id = $con->insert_id;

        // 2️⃣ Tạo chi tiết đơn hàng
        $stmt_detail = $con->prepare("
            INSERT INTO tbl_order_details (order_id, product_id, quantity, unit_price, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())
        ");
        foreach ($cart_items as $item) {
            $stmt_detail->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['unit_price']);
            $stmt_detail->execute();
        }

        // 3️⃣ Xóa giỏ hàng
        $stmt_del_cart = $con->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
        $stmt_del_cart->bind_param("i", $user_id);
        $stmt_del_cart->execute();

        mysqli_commit($con);

        // Nếu chọn Banking → sang trang hướng dẫn chuyển khoản
        if ($payment_method === "Banking") {
            header("Location: payment_banking.php?order_id=" . $order_id);
        } else {
            $_SESSION['cart_success'] = "Checkout successful! Your order ID is #" . $order_id;
            header("Location: order_success.php?order_id=" . $order_id);
        }
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
<style>
.address-box {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
}
.payment-extra {
    display: none;
    margin-top: 15px;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    background: #f8f9f8;
}
</style>
</head>
<body>
<div class="container my-5">
    <h3 class="mb-4">🛒 Checkout</h3>

    <?php if (isset($_SESSION['cart_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['cart_error']; unset($_SESSION['cart_error']); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <!-- ĐỊA CHỈ -->
        <h5>📍 Shipping Address</h5>
        <div class="mb-3">
            <div class="form-check address-box">
                <input class="form-check-input" type="radio" name="address_option" id="oldAddress" value="old" checked>
                <label class="form-check-label" for="oldAddress">
                    Use registered address: <strong><?= htmlspecialchars($user['address'] ?: 'Not available') ?></strong>
                </label>
                <input type="hidden" name="shipping_address_old" value="<?= htmlspecialchars($user['address']) ?>">
            </div>

            <div class="form-check address-box">
                <input class="form-check-input" type="radio" name="address_option" id="newAddress" value="new">
                <label class="form-check-label" for="newAddress">Enter new address</label>
                <textarea class="form-control mt-2" id="shipping_address_new" name="shipping_address_new" rows="3" placeholder="Enter your new shipping address"></textarea>
            </div>
        </div>

        <!-- PHƯƠNG THỨC THANH TOÁN -->
        <h5>💳 Payment Method</h5>
        <div class="mb-3">
            <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="">Select method</option>
                <option value="COD">Cash on Delivery (COD)</option>
                <option value="Banking">Bank Transfer (Chuyển khoản)</option>
            </select>

            <!-- Form hướng dẫn chuyển khoản -->
            <div class="payment-extra" id="bankingInfo">
                <h6>🏦 Bank Transfer Information</h6>
                <p>Please transfer the total amount to the following account:</p>
                <ul>
                    <li><strong>Bank:</strong> Vietcombank</li>
                    <li><strong>Account Number:</strong> 0123456789</li>
                    <li><strong>Account Name:</strong> Beauty Shop Co., Ltd</li>
                    <li><strong>Content:</strong> Order #<?= rand(1000,9999) ?> - <?= htmlspecialchars($user['FirstName']); ?></li>
                </ul>
                <p class="text-muted small">After completing the transfer, please click “Place Order”. We will confirm your payment and process your order.</p>
            </div>
        </div>

        <!-- ORDER SUMMARY -->
        <h5 class="mt-4">📦 Order Summary</h5>
        <ul class="list-group mb-3">
            <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($item['title']); ?> x <?= intval($item['quantity']); ?>
                    <span>$<?= number_format($item['quantity'] * $item['unit_price'], 2); ?></span>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item d-flex justify-content-between">
                <strong>Total</strong>
                <strong>$<?= number_format($total_order, 2); ?></strong>
            </li>
        </ul>

        <button type="submit" class="btn btn-success">Place Order</button>
    </form>
</div>

<script>
const paymentSelect = document.getElementById('payment_method');
const bankingInfo = document.getElementById('bankingInfo');

paymentSelect.addEventListener('change', function() {
    bankingInfo.style.display = (this.value === 'Banking') ? 'block' : 'none';
});
</script>
</body>
</html>
