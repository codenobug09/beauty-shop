<?php
session_start();
include('includes/dbconnection.php');

$user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid'])>0 ? intval($_SESSION['bpmsuid']) : 0;
$session_token = session_id();

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'update') {
    $cart_id = intval($_POST['cart_id']);
    $quantity = max(1, intval($_POST['quantity']));

    // Kiểm tra xem item có tồn tại không
    $stmt = $con->prepare("SELECT unit_price FROM tbl_cart WHERE id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $_SESSION['cart_error'] = "Cart item not found.";
        header("Location: cart.php");
        exit;
    }

    // Chỉ cập nhật quantity và updated_at
    $stmt_up = $con->prepare("UPDATE tbl_cart SET quantity = ?, updated_at = NOW() WHERE id = ?");
    $stmt_up->bind_param("ii", $quantity, $cart_id);
    $stmt_up->execute();

    $_SESSION['cart_success'] = "Cart updated successfully.";
    header("Location: cart.php");
    exit;
}




if ($action == 'remove') {
    $cart_id = intval($_POST['cart_id']);

    // kiểm quyền
    $stmt_check = $con->prepare("SELECT user_id, session_id FROM tbl_cart WHERE id = ? AND status='active'");
    $stmt_check->bind_param("i", $cart_id);
    $stmt_check->execute();
    $own = $stmt_check->get_result()->fetch_assoc();
    if (!$own) {
        $_SESSION['cart_error'] = "Item not found.";
        header("Location: cart.php");
        exit;
    }
    if (!($own['user_id'] == $user_id || ($own['user_id'] == 0 && $own['session_id'] == $session_token))) {
        $_SESSION['cart_error'] = "Not authorized.";
        header("Location: cart.php");
        exit;
    }

    $stmt_del = $con->prepare("DELETE FROM tbl_cart WHERE id = ?");
    $stmt_del->bind_param("i", $cart_id);
    $stmt_del->execute();
    $_SESSION['cart_success'] = "Item removed.";
    header("Location: cart.php");
    exit;
}

// default
header("Location: cart.php");
exit;
?>
