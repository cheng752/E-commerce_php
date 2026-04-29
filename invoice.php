<?php
require_once 'conn.php';

$order_id = $_GET['order_id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT oi.order_item_id, oi.order_id, oi.product_id, p.product_name,
           oi.quantity, oi.price, oi.total_price, oi.name, oi.created_at
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$items) {
    echo "Invalid order ID.";
    exit;
}

$total_price = array_sum(array_column($items, 'total_price'));
$customer_name = $items[0]['name'];
$order_date = $items[0]['created_at'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?= htmlspecialchars($order_id) ?></title>
</head>
<body>
    <h2>Invoice - Order #<?= htmlspecialchars($order_id) ?></h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($customer_name) ?></p>
    <p><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($order_date)) ?></p>

    <table border="1" cellpadding="10">
        <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>$<?= number_format($item['total_price'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><strong>Total: $<?= number_format($total_price, 2) ?></strong></p>
    <button onclick="window.print()">Print</button>
</body>
</html>
