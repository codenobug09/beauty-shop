<?php
session_start();
include("includes/dbconnection.php");
$user_id = $_SESSION['bpmsuid'] ?? null;

if (!$user_id) {
    echo "<script>
        alert('You have to login first!');
        window.location.href='login.php';
    </script>";
    exit();
}

// Kiểm tra xem có product_id được gửi sang không
if (!isset($_GET['product_id'])) {
    echo "<p>Invalid product request.</p>";
    exit();
}

$product_id = intval($_GET['product_id']);
$query = mysqli_query($con, "SELECT * FROM tblproduct WHERE p_id = '$product_id'");

if (mysqli_num_rows($query) == 0) {
    echo "<p>Product not found.</p>";
    exit();
}

$product = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f9f9f9;
        }
        .order-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .order-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        .order-details {
            padding: 25px;
        }
        .order-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .order-slogan {
            color: #666;
            margin-bottom: 20px;
        }
        .order-price {
            font-size: 1.4rem;
            color: #e74c3c;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .quantity-control button {
            background: #f2f2f2;
            border: none;
            width: 35px;
            height: 35px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }
        .quantity-control input {
            width: 60px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 35px;
        }
        .btn-buy, .btn-cart {
            width: 48%;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-cart {
            background: #3498db;
            color: white;
            border: none;
        }
        .btn-cart:hover {
            background: #2980b9;
        }
        .btn-buy {
            background: #e74c3c;
            color: white;
            border: none;
        }
        .btn-buy:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>

<div class="order-container">
    <img src="assets/images/<?php echo htmlspecialchars($product['img']); ?>" class="order-img" alt="<?php echo htmlspecialchars($product['title']); ?>">
    <div class="order-details">
        <h2 class="order-title"><?php echo htmlspecialchars($product['title']); ?></h2>
        <p class="order-slogan"><?php echo htmlspecialchars($product['slogan']); ?></p>
        <p class="order-price">$<?php echo number_format($product['price'], 2); ?></p>

        <form method="post" action="add-to-cart.php">
            <div class="quantity-control">
                <label for="quantity" class="form-label mb-0">Quantity:</label>
                <button type="button" onclick="updateQuantity(-1)"><i class="fa fa-minus"></i></button>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
                <button type="button" onclick="updateQuantity(1)"><i class="fa fa-plus"></i></button>
            </div>

            <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">

            <div class="d-flex justify-content-between">
                <button type="submit" name="add_to_cart" class="btn-cart"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                <button type="submit" name="buy_now" class="btn-buy"><i class="fa fa-bolt"></i> Buy Now</button>
            </div>
        </form>
    </div>
</div>

<script>
function updateQuantity(change) {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value) + change;
    if (val < 1) val = 1;
    input.value = val;
}
</script>

</body>
</html>
