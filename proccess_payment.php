<?php
session_start();
header('Content-Type: application/json');
require_once 'conn.php';
require_once 'admin/lib/libraryCRUD.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty']);
    exit;
}

$cart = $_SESSION['cart'];
$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$created_at = date('Y-m-d H:i:s');

try {
    $pdo->beginTransaction();

    // Insert into orders
    $stmt = $pdo->prepare("INSERT INTO orders (full_name, email, phone, address, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $email, $phone, $address, $created_at]);
    $order_id = $pdo->lastInsertId();

    // Insert order items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, total_price, name, created_at)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($cart as $item) {
        $stmt->execute([
            $order_id,
            $item['id'],
            $item['quantity'],
            $item['price'],
            $item['price'] * $item['quantity'],
            $full_name,
            $created_at
        ]);
    }

    $pdo->commit();
    $_SESSION['cart'] = []; // Clear cart
    echo json_encode(['success' => true, 'order_id' => $order_id]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
