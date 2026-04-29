<?php
include("conn.php");
include("admin/Lib/libraryCRUD.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$crud = new CRUDLibrary($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit;
    }
    
    // Get user input
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $total_price = $_POST["total"];
    $order_status = "Pending";
    $created_at = date("Y-m-d H:i:s");
    
    // Insert order into orders table
    $orderData = [
        "user_id" => $user_id,
        "name" => $name,
        "email" => $email,
        "address" => $address,
        "total_price" => $total_price,
        "order_status" => $order_status,
        "created_at" => $created_at
    ];
    
    if ($crud->create("orders", $orderData)) {
        $order_id = $pdo->lastInsertId();
        
        // Insert cart items into order_items table
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $itemData = [
                    "order_id" => $order_id,
                    "product_id" => $item['id'],
                    "product_name" => $item['name'],
                    "price" => $item['price'],
                    "quantity" => $item['quantity']
                ];
                $crud->create("order_items", $itemData);
            }
        }
        
        // Clear the cart session
        unset($_SESSION['cart']);
        
        // Redirect to invoice page
        header("Location: invoice.php?order_id=" . $order_id);
        exit;
    } else {
        echo "Error processing order.";
    }
}
?>
