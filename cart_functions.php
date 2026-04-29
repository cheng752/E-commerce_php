<?php
function addToCart($productId, $image, $productName, $price, $qty) {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Validate the inputs
    if (!isset($productId, $image, $productName, $price, $qty)) {
        return false; // Return false if required data is not set
    }

    // Create a product object
    $product = array(
        'id' => $productId,
        'image' => $image,
        'name' => $productName,
        'price' => $price,
        'quantity' => $qty
    );

    // Get the current cart from session (or initialize as an empty array)
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    // Check if the product is already in the cart
    $existingProductIndex = -1;
    foreach ($cart as $index => $item) {
        if ($item['id'] === $productId) {
            $existingProductIndex = $index;
            break;
        }
    }

    if ($existingProductIndex > -1) {
        // Update the quantity if the product already exists
        $cart[$existingProductIndex]['quantity'] += $qty;
    } else {
        // Add the product to the cart
        $cart[] = $product;
    }

    // Save the updated cart back to the session
    $_SESSION['cart'] = $cart;

    return true;
}
?>
