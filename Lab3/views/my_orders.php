
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

require_login();

$cartController = new CartController();

$customer_id = (int) $_SESSION['customer_id'];

$orders = $cartController->getCustomerOrders($customer_id);

$groupedOrders = [];

foreach ($orders as $item) {
    $orderId = $item['order_id'];

    if (!isset($groupedOrders[$orderId])) {
        $groupedOrders[$orderId] = [
            'invoice_no' => $item['invoice_no'],
            'order_date' => $item['order_date'],
            'order_status' => $item['order_status'],
            'items' => [],
            'total' => 0
        ];
    }

    $subtotal = (int) $item['qty'] * (float) $item['product_price'];

    $groupedOrders[$orderId]['items'][] = [
        'product_title' => $item['product_title'],
        'qty' => $item['qty'],
        'price' => $item['product_price'],
        'subtotal' => $subtotal
    ];

    $groupedOrders[$orderId]['total'] += $subtotal;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders</title>

    <style>
        .orders-page {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px 50px;
        }

        .orders-page h1 {
            color: #a61e62;
        }

        .order-card {
            background: white;
            border: 1px solid #f3d4e3;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 7px 20px rgba(214, 51, 132, 0.07);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .order-status {
            color: #198754;
            font-weight: bold;
            text-transform: capitalize;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .order-table th,
        .order-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .order-table th {
            color: #a61e62;
        }

        .order-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #a61e62;
        }

        .back-link,
        .shop-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #d63384;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        .empty-orders {
            background: #fff0f6;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<main class="orders-page">

    <h1>My Orders</h1>
    <p>View your previous purchases and payment details.</p>

    <a href="my_account.php" class="back-link">Back to My Account</a>

    <?php if (empty($groupedOrders)): ?>

        <div class="empty-orders">
            <h2>No orders yet</h2>
            <p>You have not placed any orders yet.</p>
            <a href="index.php" class="shop-link">Start Shopping</a>
        </div>

    <?php else: ?>

        <?php foreach ($groupedOrders as $orderId => $order): ?>

            <section class="order-card">

                <div class="order-header">
                    <div>
                        <h2>Invoice #<?php echo htmlspecialchars($order['invoice_no']); ?></h2>
                        <p>Order date: <?php echo htmlspecialchars($order['order_date']); ?></p>
                    </div>

                    <div class="order-status">
                        <?php echo htmlspecialchars($order['order_status']); ?>
                    </div>
                </div>

                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                                <td><?php echo (int) $item['qty']; ?></td>
                                <td>GHS <?php echo number_format((float) $item['price'], 2); ?></td>
                                <td>GHS <?php echo number_format((float) $item['subtotal'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="order-total">
                    Total: GHS <?php echo number_format((float) $order['total'], 2); ?>
                </div>

            </section>

        <?php endforeach; ?>

    <?php endif; ?>

</main>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>
