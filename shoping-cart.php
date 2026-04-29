<?php
// Check if the cart exists, if not, initialize it as an empty array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle removing a product from the cart
if (isset($_POST['remove'])) {
    $productIndex = $_POST['remove']; // Get the product index to remove
    unset($_SESSION['cart'][$productIndex]); // Remove product from cart
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the cart array
}

// Handle updating the quantity of a product
if (isset($_POST['update_quantity'])) {
    $productIndex = $_POST['product_index']; // Get the product index
    $newQuantity = $_POST['quantity']; // Get the new quantity

    // Update the quantity in the cart
    if ($newQuantity > 0) {
        $_SESSION['cart'][$productIndex]['quantity'] = $newQuantity;
    }
}

// Retrieve the cart contents
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Include your CSS file -->
</head>
<body>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.php?p=home" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Shopping Cart
            </span>
        </div>
    </div>

    <!-- Shopping Cart -->
    <form class="bg0 p-t-75 p-b-85" action="index.php?p=checkout" method="POST">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                    <th class="column-6">Action</th>
                                </tr>

                                <?php foreach ($cart as $index => $product): ?>
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="admin/uploads/products/<?php echo $product['image']; ?>" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2"><?php echo $product['name']; ?></td>
                                        <td class="column-3">$<?php echo number_format($product['price'], 2); ?></td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">


                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">$<?php echo number_format($product['price'] * $product['quantity'], 2); ?></td>
                                        <td class="column-6">
                                            <button type="submit" name="remove" value="<?php echo $index; ?>">Remove</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">
                                
                                <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div>

                            <div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Update Cart
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Subtotal:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    $<?php
                                        $subtotal = 0;
                                        foreach ($cart as $product) {
                                            $subtotal += $product['price'] * $product['quantity'];
                                        }
                                        echo number_format($subtotal, 2);
                                    ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    $<?php
                                        $total = $subtotal; // You can add shipping costs if needed
                                        echo number_format($total, 2);
                                    ?>
                                </span>
                            </div>
                        </div>


                        <button type="submit"  class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
