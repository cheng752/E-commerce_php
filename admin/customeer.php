<?php
include("../conn.php");
include("lib/libraryCRUD.php");

$crud = new CRUDLibrary($pdo);

// Fetch customers who have placed orders
$sql = "SELECT u.user_id, u.name AS full_name, u.email, u.phone, u.address, 
               COUNT(o.order_id) AS total_orders, COALESCE(SUM(o.total_price), 0) AS total_spent
        FROM users u
        LEFT JOIN orders o ON u.user_id = o.user_id
        GROUP BY u.user_id, u.name, u.email, u.phone, u.address
        ORDER BY total_orders DESC";

$customers = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Customer List</h2>
    
    <?php if (count($customers) > 0): ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Total Orders</th>
                    <th>Total Spent ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= htmlspecialchars($customer["user_id"]); ?></td>
                        <td><?= htmlspecialchars($customer["full_name"]); ?></td>
                        <td><?= htmlspecialchars($customer["email"]); ?></td>
                        <td><?= htmlspecialchars($customer["phone"]); ?></td>
                        <td><?= htmlspecialchars($customer["address"]); ?></td>
                        <td><?= $customer["total_orders"]; ?></td>
                        <td>$<?= number_format($customer["total_spent"], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No customers found.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
