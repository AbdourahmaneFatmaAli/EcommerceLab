<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

// Only accept POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/cart.php");
    exit;
}

$ip = get_ip();
$quantities = $_POST['qty'] ?? [];
$productIds = $_POST['update'] ?? [];

if (!is_array($quantities) || !is_array($productIds)) {
    $_SESSION['cart_message'] = "Invalid cart quantity data.";
    header("Location: ../views/cart.php");
    exit;
}

$cartController = new CartController();
$updatedCount = 0;

foreach ($productIds as $productId) {
    $productId = filter_var($productId, FILTER_VALIDATE_INT);

    if ($productId === false || $productId < 1) {
        continue;
    }

    if (!array_key_exists($productId, $quantities)) {
        continue;
    }

    $qty = filter_var($quantities[$productId], FILTER_VALIDATE_INT);

    if ($qty !== false && $qty >= 1) {
        if ($cartController->updateQty($productId, $qty, $ip)) {
            $updatedCount++;
        }
    }
}

if ($updatedCount > 0) {
    $_SESSION['cart_message'] = "Cart quantities have been updated.";
} else {
    $_SESSION['cart_message'] = "No quantities were updated. Enter quantities of at least 1.";
}

header("Location: ../views/cart.php");
exit;
