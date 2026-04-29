<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to cart if it's empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$success_message = '';

// Handle order submission via the form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Normally you would insert the order into a database here.

    $_SESSION['cart'] = []; // Clear the cart
    $success_message = "🎉 Your order has been placed successfully!";
}

$cart = $_SESSION['cart'];
$total = array_sum(array_map(function ($product) {
    return $product['price'] * $product['quantity'];
}, $cart));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <script src="https://www.paypal.com/sdk/js?client-id=Acu3Fc7--_KQhu9iNKiGvfKv1MhjzIlR08iM015lB_ujFDCVUhXhNCLh7FognblgGU1lFST6qudJA_OH&currency=USD"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .form-container {
            flex: 0 0 48%;
            padding: 20px;
        }
        .order-summary {
            flex: 0 0 48%;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 6px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 25px;
            color: #444;
        }
        label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 16px;
            color: #444;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            transition: border 0.3s ease;
        }
        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            border-color: #5cb85c;
            outline: none;
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        h3 {
            font-size: 20px;
            color: #333;
            margin-top: 20px;
        }
        .order-summary ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .order-summary ul li {
            font-size: 16px;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .order-summary ul li:last-child {
            border-bottom: none;
        }
        .total {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-top: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #5cb85c;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #4cae4c;
        }
        @media (max-width: 800px) {
            .container {
                flex-direction: column;
                padding: 20px;
            }
            .form-container, .order-summary {
                flex: 1 1 100%;
                margin-bottom: 20px;
            }
            h2 {
                font-size: 24px;
            }
            h3 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form Container -->
        <div class="form-container">
            <h2>Checkout</h2>

            <?php if (!empty($success_message)): ?>
                <div style="background-color: #dff0d8; color: #3c763d; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #d6e9c6;">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (empty($success_message)): ?>
                <form method="POST">
                    <label>Full Name:</label>
                    <input type="text" name="full_name" required>
                    
                    <label>Email:</label>
                    <input type="email" name="email" required>
                    
                    <label>Phone:</label>
                    <input type="text" name="phone" required>
                    
                    <label>Shipping Address:</label>
                    <textarea name="address" required></textarea>
                    
                    <!-- Place Order Button -->
                    <button type="submit" name="place_order">Place Order</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Order Summary and PayPal Button Container -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <ul>
                <?php foreach ($cart as $product): ?>
                    <li><?php echo htmlspecialchars($product['name']) . " x " . $product['quantity'] . " - $" . number_format($product['price'] * $product['quantity'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
            <p class="total">Total: $<?php echo number_format($total, 2); ?></p>

            <!-- PayPal Button Container -->
            <div id="paypal-button-container" style="margin-top: 20px;"></div>
        </div>
    </div>

    <!-- PayPal Buttons Script -->
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "<?php echo number_format($total, 2, '.', ''); ?>"
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Payment Successful! Thank you, ' + details.payer.name.given_name + '.');
                    window.location.href = "index.php?p=checkout";
                });
            },
            onError: function(err) {
                console.error('PayPal Checkout onError', err);
                alert('An error occurred during the payment process.');
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
