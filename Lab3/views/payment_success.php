
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

require_login();

$orderId = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);

if (!$orderId || $orderId < 1) {
    $_SESSION['payment_error'] = "Invalid order number.";
    header("Location: payment_failed.php");
    exit;
}

$cartController = new CartController();
$orderItems = $cartController->getOrderById($orderId);

if (empty($orderItems)) {
    $_SESSION['payment_error'] = "Order could not be found.";
    header("Location: payment_failed.php");
    exit;
}

// Make sure this order belongs to the logged-in customer.
if ((int)$orderItems[0]['customer_id'] !== (int)$_SESSION['customer_id']) {
    http_response_code(403);
    exit("You are not allowed to view this invoice.");
}

$firstItem = $orderItems[0];

$total = 0;

foreach ($orderItems as $item) {
    $total += (int)$item['qty'] * (float)$item['product_price'];
}

require_once __DIR__ . "/layout/header.php";
?>

<style>
.invoice-container {
    max-width: 850px;
    margin: 40px auto;
    padding: 30px;
    background: #fff;
    border: 1px solid #f0d5e2;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(100, 50, 75, 0.08);
    box-sizing: border-box;
}

.success-heading {
    text-align: center;
    color: #27834b;
    margin-bottom: 25px;
}

.invoice-container h2 {
    color: #8f1d55;
}

.invoice-info {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    margin: 25px 0;
    color: #542b42;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.invoice-table th,
.invoice-table td {
    padding: 12px;
    border-bottom: 1px solid #f0d5e2;
    text-align: left;
    color: #542b42;
}

.invoice-table th {
    background: #fff0f6;
    color: #8f1d55;
}

.invoice-total {
    text-align: right;
    color: #8f1d55;
    font-size: 22px;
    font-weight: bold;
    margin-top: 25px;
}

.invoice-actions {
    display: flex;
    gap: 12px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.invoice-button {
    display: inline-block;
    padding: 12px 20px;
    background: #d63384;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.invoice-button:hover {
    background: #a61e62;
    color: white;
}

@media print {
    header, footer, .invoice-actions {
        display: none !important;
    }

    .invoice-container {
        box-shadow: none;
        border: none;
    }
}

@media(max-width: 600px) {
    .invoice-container {
        margin: 20px 12px;
        padding: 18px;
    }

    .invoice-table th,
    .invoice-table td {
        padding: 8px;
        font-size: 13px;
    }
}
</style>

<div class="invoice-container">

    <div class="success-heading">
        <h1>Payment Successful!</h1>
        <p>Your payment has been verified and your order has been recorded.</p>
    </div>

    <h2>Order Invoice</h2>

    <div class="invoice-info">
        <div>
            <strong>Invoice Number:</strong>
            <?php echo htmlspecialchars((string)$firstItem['invoice_no']); ?>
            <br>

            <strong>Order Number:</strong>
            <?php echo (int)$firstItem['order_id']; ?>
        </div>

        <div>
            <strong>Customer:</strong>
            <?php
            echo htmlspecialchars(
                $_SESSION['customer_name'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );
            ?>
            <br>

            <strong>Email:</strong>
            <?php
            echo htmlspecialchars(
                $_SESSION['customer_email'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );
            ?>
            <br>

            <strong>Date:</strong>
            <?php echo htmlspecialchars((string)$firstItem['order_date']); ?>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($orderItems as $item) { ?>

                <?php
                $quantity = (int)$item['qty'];
                $price = (float)$item['product_price'];
                ?>

                <tr>
                    <td>
                        <?php
                        echo htmlspecialchars(
                            $item['product_title'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </td>

                    <td><?php echo $quantity; ?></td>

                    <td>GHS <?php echo number_format($price, 2); ?></td>

                    <td>
                        GHS <?php echo number_format($quantity * $price, 2); ?>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>

    <div class="invoice-total">
        Total Paid: GHS <?php echo number_format($total, 2); ?>
    </div>

    <p>
        <strong>Payment Status:</strong> Paid
    </p>

    <div class="invoice-actions">
        <button class="invoice-button" onclick="window.print()">
            Print Invoice
        </button>

        <a
            class="invoice-button"
            href="/~fatma.abdourahmane/Ecommerce-class/Lab3/index.php"
        >
            Continue Shopping
        </a>
    </div>

</div>

<?php require_once __DIR__ . "/layout/footer.php"; ?>
