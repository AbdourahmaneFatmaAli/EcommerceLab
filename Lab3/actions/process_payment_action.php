
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";
require_once __DIR__ . "/../core/paystack_config.php";

function paymentFailed($message)
{
    $_SESSION['payment_error'] = $message;
    header("Location: ../views/payment_failed.php");
    exit;
}

// Only accept POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    paymentFailed("Invalid payment request.");
}

// Customer must be logged in.
if (!is_logged_in()) {
    paymentFailed("Please log in before making a payment.");
}

// Get the Paystack reference sent from the payment page.
$reference = trim($_POST['reference'] ?? '');

if ($reference === '') {
    paymentFailed("Payment reference is missing.");
}

// Check that the secret key is configured.
if (
    !defined('PAYSTACK_SECRET_KEY') ||
    PAYSTACK_SECRET_KEY === ''
) {
    paymentFailed("Paystack is not configured.");
}

try {
    // Verify the transaction directly with Paystack.
    $url = "https://api.paystack.co/transaction/verify/"
         . rawurlencode($reference);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . PAYSTACK_SECRET_KEY,
            "Cache-Control: no-cache"
        ],
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($curl);
    $curlError = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($response === false) {
        throw new Exception("Could not contact Paystack: " . $curlError);
    }

    $result = json_decode($response, true);

    if (
        $httpCode !== 200 ||
        !is_array($result) ||
        empty($result['status']) ||
        empty($result['data'])
    ) {
        throw new Exception("Paystack could not verify this payment.");
    }

    $payment = $result['data'];

    // Confirm the payment was successful.
    if (($payment['status'] ?? '') !== 'success') {
        throw new Exception("Your payment was not successful.");
    }

    // Confirm the reference matches.
    if (($payment['reference'] ?? '') !== $reference) {
        throw new Exception("Payment reference does not match.");
    }

    // Confirm the currency is Ghana cedis.
    if (($payment['currency'] ?? '') !== 'GHS') {
        throw new Exception("Unexpected payment currency.");
    }

    // Confirm the payment belongs to the logged-in customer.
    $customerEmail = strtolower(trim($_SESSION['customer_email'] ?? ''));
    $paymentEmail = strtolower(trim($payment['customer']['email'] ?? ''));

    if (
        $customerEmail === '' ||
        $paymentEmail === '' ||
        $customerEmail !== $paymentEmail
    ) {
        throw new Exception("Payment email does not match your account.");
    }

    $ip = get_ip();

    $controller = new CartController();

    // Calculate the expected cart amount in pesewas.
    $expectedAmount = (int) round(
        $controller->getCartTotal($ip) * 100
    );

    $paidAmount = (int) ($payment['amount'] ?? 0);

    if ($expectedAmount <= 0 || $paidAmount !== $expectedAmount) {
        throw new Exception("The payment amount does not match your cart.");
    }

    // Record the verified payment and create the order.
    $orderId = $controller->processPayment(
        $_SESSION['customer_id'],
        $ip,
        $reference,
        $paidAmount
    );

    if (!$orderId) {
        throw new Exception("Could not create your order.");
    }

    // Payment and order were successfully processed.
    header("Location: ../views/payment_success.php?order_id=" . urlencode($orderId));
    exit;

} catch (Throwable $e) {
    error_log("Payment processing error: " . $e->getMessage());
    paymentFailed($e->getMessage());
}
