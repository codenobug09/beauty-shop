<?php
include('includes/dbconnection.php');

if (!isset($_GET['p_id']) || empty($_GET['p_id'])) {
    header('Location: add-product.php');
    exit;
}

$p_id = intval($_GET['p_id']);

// Lấy thông tin sản phẩm để xóa ảnh nếu có
$stmt = $con->prepare("SELECT img FROM tblproduct WHERE p_id = ?");
$stmt->execute([$p_id]);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($product) {
    // Xóa ảnh cũ nếu tồn tại
    if ($product['img'] != '' && file_exists('../assets/images/' . $product['img'])) {
        unlink('../assets/images/' . $product['img']);
    }

    // Xóa sản phẩm
    $del = $con->prepare("DELETE FROM tblproduct WHERE p_id = ?");
    $del->execute([$p_id]);

    echo "<script>alert('Đã xóa sản phẩm thành công!');window.location='add-product.php';</script>";
} else {
    echo "<script>alert('Không tìm thấy sản phẩm cần xóa!');window.location='add-product.php';</script>";
}
?>
