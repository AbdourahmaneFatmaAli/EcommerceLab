
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

require_login();

$cartController = new CartController();
$ip = get_ip();

$cartItems = $cartController->getCartItems($ip);
$cartTotal = $cartController->getCartTotal($ip);

if (empty($cartItems)) {
    $_SESSION['cart_message'] = "Your cart is empty.";
    header("Location: cart.php");
    exit;
}

$customerEmail = $_SESSION['customer_email'] ?? '';
$amountInPesewas = (int) round($cartTotal * 100);

// Replace this with your Paystack TEST PUBLIC key.
$paystackPublicKey = 'pk_test_a32cb82ebb9c51f0889a47e29127b13c7c87fdf3';

require_once __DIR__ . "/layout/header.php";
?>

<style>
.payment-container {
    max-width: 850px;
    margin: 40px auto;
    padding: 30px;
    background: #fff;
    border: 1px solid #f0d5e2;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(100, 50, 75, 0.08);
    box-sizing: border-box;
}

.payment-container h1 {
    color: #8f1d55;
    margin-bottom: 10px;
}

.payment-container p {
    color: #542b42;
}

.payment-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
}

.payment-table th,
.payment-table td {
    padding: 13px;
    border-bottom: 1px solid #f0d5e2;
    text-align: left;
    color: #542b42;
}

.payment-table th {
    color: #8f1d55;
    background: #fff0f6;
}

.payment-total {
    text-align: right;
    color: #8f1d55;
    font-size: 22px;
    font-weight: bold;
    margin: 25px 0;
}

.pay-button {
    display: inline-block;
    padding: 13px 25px;
    background: #d63384;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.pay-button:hover {
    background: #a61e62;
}

.back-link {
    display: inline-block;
    margin-left: 12px;
    color: #8f1d55;
    text-decoration: none;
}

@media(max-width: 600px) {
    .payment-container {
        margin: 20px 12px;
        padding: 18px;
    }

    .payment-table th,
    .payment-table td {
        padding: 8px;
        font-size: 13px;
    }
}
</style>

<div class="payment-container">

    <h1>Order Summary</h1>

    <p>Please review your items before proceeding with payment.</p>

    <table class="payment-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($cartItems as $item) { ?>

                <?php
                $title = $item['product_title'] ?? '';
                $quantity = (int) $item['qty'];
                $price = (float) $item['product_price'];
                ?>

                <tr>
                    <td>
                        <?php
                        echo htmlspecialchars(
                            $title,
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </td>

                    <td><?php echo $quantity; ?></td>

                    <td>GHS <?php echo number_format($price, 2); ?></td>

                    <td>
                        GHS <?php
                        echo number_format($quantity * $price, 2);
                        ?>
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>

    <div class="payment-total">
        Total: GHS <?php echo number_format($cartTotal, 2); ?>
    </div>

    <button
        type="button"
        class="pay-button"
        id="payButton"
    >
        Pay with Paystack
    </button>

    <a href="cart.php" class="back-link">Back to Cart</a>

</div>

<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
const payButton = document.getElementById('payButton');

payButton.addEventListener('click', function () {

    const handler = PaystackPop.setup({

        key: <?php echo json_encode($paystackPublicKey); ?>,

        email: <?php echo json_encode($customerEmail); ?>,

        amount: <?php echo $amountInPesewas; ?>,

        currency: 'GHS',

        callback: function(response) {

            const form = document.createElement('form');

            form.method = 'POST';
            form.action = '../actions/process_payment_action.php';

            const reference = document.createElement('input');

            reference.type = 'hidden';
            reference.name = 'reference';
            reference.value = response.reference;

            form.appendChild(reference);

            document.body.appendChild(form);

            form.submit();
        },

        onClose: function() {
            alert('Payment window closed. Your order has not been submitted.');
        }

    });

    handler.openIframe();
});
</script>

<?php require_once __DIR__ . "/layout/footer.php"; ?>
