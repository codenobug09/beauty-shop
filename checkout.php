    <?php
    session_start();
    include('includes/dbconnection.php');

    $user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;
    if ($user_id == 0) {
        $_SESSION['cart_error'] = "You must login to checkout.";
        header("Location: cart.php");
        exit;
    }

    /* ================= USER INFO ================= */
    $stmt_user = $con->prepare("SELECT FirstName, email, address FROM tbluser WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $user = $stmt_user->get_result()->fetch_assoc();

    /* ================= CART ================= */
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
    $total_order = 0;
    while ($row = $res_cart->fetch_assoc()) {
        $cart_items[] = $row;
        $total_order += $row['quantity'] * $row['unit_price'];
    }

    /* ================= BANK QR INFO ================= */
    /* ================= BANK QR INFO (MB BANK – VIETQR IMAGE) ================= */
    $acqId = "970422"; // MB Bank BIN
    $account_number = "3228609012003";
    $account_name = "NGUYEN MINH CHAU";

    $transfer_content = "ORDER_" . $user_id . "_" . time();
    $amount = intval(round($total_order));

    $vietqr_url = "https://img.vietqr.io/image/{$acqId}-{$account_number}-compact2.png"
        . "?amount={$amount}"
        . "&addInfo=" . urlencode($transfer_content)
        . "&accountName=" . urlencode($account_name);



    /* ================= SUBMIT ================= */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $address_option = $_POST['address_option'] ?? '';
        $shipping_address = ($address_option === 'new')
            ? trim($_POST['shipping_address_new'])
            : trim($_POST['shipping_address_old']);

        $payment_method = trim($_POST['payment_method'] ?? '');

        if (empty($shipping_address) || empty($payment_method)) {
            $_SESSION['cart_error'] = "Please fill in all required fields.";
            header("Location: checkout.php");
            exit;
        }

        mysqli_begin_transaction($con);

        try {
            /* ORDER */
            $stmt_order = $con->prepare("
                INSERT INTO tblorders 
                (user_id, status, total, shipping_address, payment_method, created_at, updated_at)
                VALUES (?, 'pending', ?, ?, ?, NOW(), NOW())
            ");
            $stmt_order->bind_param("idss", $user_id, $total_order, $shipping_address, $payment_method);
            $stmt_order->execute();
            $order_id = $con->insert_id;

            /* ORDER DETAILS */
            $stmt_detail = $con->prepare("
                INSERT INTO tbl_order_details 
                (order_id, product_id, quantity, unit_price, created_at, updated_at)
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

            /* CLEAR CART */
            $stmt_del_cart = $con->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
            $stmt_del_cart->bind_param("i", $user_id);
            $stmt_del_cart->execute();

            mysqli_commit($con);

            if ($payment_method === "Banking") {
                header("Location: payment_banking.php?order_id=" . $order_id);
            } else {
                $_SESSION['cart_success'] = "Checkout successful! Order ID: #" . $order_id;
                header("Location: order_success.php?order_id=" . $order_id);
            }
            exit;

        } catch (Exception $e) {
            mysqli_rollback($con);
            $_SESSION['cart_error'] = "Checkout failed!";
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
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .payment-extra {
        display: none;
        margin-top: 15px;
        border: 1px dashed #ccc;
        padding: 15px;
        border-radius: 10px;
        background: #fdfdfd;
    }
    </style>
    </head>
    <body>

    <div class="container my-5">
        <h3 class="mb-4">🛒 Checkout</h3>

        <?php if (isset($_SESSION['cart_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['cart_error']; unset($_SESSION['cart_error']); ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <!-- ADDRESS -->
            <h5>📍 Shipping Address</h5>
            <div class="mb-3">
                <div class="form-check address-box">
                    <input class="form-check-input" type="radio" name="address_option" value="old" checked>
                    <label class="form-check-label">
                        Use registered address:
                        <strong><?= htmlspecialchars($user['address'] ?: 'Not available') ?></strong>
                    </label>
                    <input type="hidden" name="shipping_address_old" value="<?= htmlspecialchars($user['address']) ?>">
                </div>

                <div class="form-check address-box">
                    <input class="form-check-input" type="radio" name="address_option" value="new">
                    <label class="form-check-label">Enter new address</label>
                    <textarea class="form-control mt-2" name="shipping_address_new" rows="3"></textarea>
                </div>
            </div>

            <!-- PAYMENT -->
            <h5>💳 Payment Method</h5>
            <select class="form-select mb-3" id="payment_method" name="payment_method" required>
                <option value="">Select method</option>
                <option value="COD">Cash on Delivery</option>
                <option value="Banking">Bank Transfer (QR)</option>
            </select>

            <!-- QR -->
            <div class="payment-extra" id="bankingInfo">
                <h6 class="text-center">🏦 Scan QR to Pay</h6>
                <div class="text-center my-3">
                    <img alt="" src="<?= $vietqr_url ?>" class="img-fluid" style="max-width:260px">
                </div>

                <ul class="list-unstyled">
                    <li><strong>Bank:</strong> MB BANK</li>
                    <li><strong>Account:</strong> <?= $account_number ?></li>
                    <li><strong>Name:</strong> <?= $account_name ?></li>
                    <li><strong>Amount:</strong>
                        <span class="text-danger fw-bold">$<?= number_format($total_order, 2) ?></span>
                    </li>
                    <li><strong>Content:</strong> <?= $transfer_content ?></li>
                </ul>
            </div>

            <!-- SUMMARY -->
            <h5 class="mt-4">📦 Order Summary</h5>
            <ul class="list-group mb-3">
                <?php foreach ($cart_items as $item): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?= htmlspecialchars($item['title']) ?> x <?= $item['quantity'] ?>
                        <span>$<?= number_format($item['quantity'] * $item['unit_price'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>$<?= number_format($total_order, 2) ?></strong>
                </li>
            </ul>

            <button type="submit" class="btn btn-success w-100">
                Place Order
            </button>
        </form>
    </div>

    <script>
    const paymentSelect = document.getElementById('payment_method');
    const bankingInfo = document.getElementById('bankingInfo');

    paymentSelect.addEventListener('change', function () {
        bankingInfo.style.display = this.value === 'Banking' ? 'block' : 'none';
    });
    </script>

    </body>
    </html>
