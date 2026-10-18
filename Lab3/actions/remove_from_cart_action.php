
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

// Only accept POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/cart.php");
    exit;
}

$ip = get_ip();
$removeIds = $_POST['remove'] ?? [];

if (!is_array($removeIds) || empty($removeIds)) {
    $_SESSION['cart_message'] = "Please select at least one item to remove.";
    header("Location: ../views/cart.php");
    exit;
}

$cartController = new CartController();
$removedCount = 0;

foreach ($removeIds as $productId) {
    $productId = filter_var($productId, FILTER_VALIDATE_INT);

    if ($productId !== false && $productId > 0) {
        if ($cartController->removeFromCart($productId, $ip)) {
            $removedCount++;
        }
    }
}

if ($removedCount > 0) {
    $_SESSION['cart_message'] = "Selected item(s) have been removed.";
} else {
    $_SESSION['cart_message'] = "No items were removed.";
}

header("Location: ../views/cart.php");
exit;
