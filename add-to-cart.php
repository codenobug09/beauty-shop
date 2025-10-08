<?php
session_start();
include('includes/dbconnection.php'); // đảm bảo $con tồn tại

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// Lấy dữ liệu từ form
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity   = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

// Lấy user ID nếu đăng nhập, nếu chưa thì dùng session
$user_id    = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;
$session_id = session_id();

// Nếu product_id không hợp lệ
if ($product_id <= 0) {
    $_SESSION['cart_error'] = "Invalid product.";
    header("Location: order-product.php?product_id=" . $product_id);
    exit;
}

// Lấy thông tin sản phẩm (giá, tên)
$query = "SELECT p_id, title, price FROM tblproduct WHERE p_id = ?";
$stmt  = $con->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['cart_error'] = "Product not found.";
    header("Location: order-product.php?product_id=" . $product_id);
    exit;
}

$product = $result->fetch_assoc();
$unit_price = (float)$product['price'];

// Kiểm tra xem sản phẩm đã có trong giỏ chưa
$check = $con->prepare("SELECT id, quantity FROM tbl_cart WHERE (user_id = ? OR session_id = ?) AND product_id = ? AND status = 'active'");
$check->bind_param("isi", $user_id, $session_id, $product_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    // Cập nhật số lượng
    $row = $res->fetch_assoc();
    $new_qty = $row['quantity'] + $quantity;
    $update = $con->prepare("UPDATE tbl_cart SET quantity = ?, unit_price = ?, updated_at = NOW() WHERE id = ?");
    $update->bind_param("idi", $new_qty, $unit_price, $row['id']);
    $update->execute();
} else {
    // Thêm mới vào giỏ hàng
    $insert = $con->prepare("INSERT INTO tbl_cart (user_id, session_id, product_id, quantity, unit_price, status, created_at, updated_at) 
                             VALUES (?, ?, ?, ?, ?, 'active', NOW(), NOW())");
    $insert->bind_param("isiid", $user_id, $session_id, $product_id, $quantity, $unit_price);
    $insert->execute();
}

// Đặt thông báo và chuyển hướng
$_SESSION['cart_success'] = "✅ Product added to cart successfully.";
header("Location: cart.php");
exit;
?>
