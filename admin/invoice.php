<?php
include("../conn.php");
require("lib/libraryCRUD.php");

$crud = new CRUDLibrary($pdo);

// Fetch order items with product details
$sql = "SELECT oi.order_item_id, oi.order_id, oi.product_id, p.product_name, 
               oi.quantity, oi.price, oi.total_price, oi.name, oi.created_at
        FROM order_items oi
        INNER JOIN products p ON oi.product_id = p.product_id";

$orderItems = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="mb-4">Invoice</h2>

    <?php if (count($orderItems) > 0): ?>
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Item ID</th>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price ($)</th>
                <th>Total Price ($)</th>
                <th>Customer Name</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item["order_item_id"]); ?></td>
                <td><?= htmlspecialchars($item["order_id"]); ?></td>
                <td><?= htmlspecialchars($item["product_name"]); ?></td>
                <td><?= htmlspecialchars($item["quantity"]); ?></td>
                <td><?= number_format($item["price"], 2); ?></td>
                <td><?= number_format($item["total_price"], 2); ?></td>
                <td><?= htmlspecialchars($item["name"]); ?></td>
                <td><?= date('F j, Y', strtotime($item["created_at"])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No records found</p>
    <?php endif; ?>
</div>
