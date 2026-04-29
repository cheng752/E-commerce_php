<?php
include('conn.php');
$productId = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM products WHERE product_id = :productId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':productId', $productId, PDO::PARAM_INT); 
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $row['product_image']; 
    $product_name = $row['product_name']; 
    $price = $row['price']; 
    $description = $row['description']; 
} else {
    echo "Product not found.";
    exit;
}

?>