
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

// Read the product ID from the URL.
$product_id = filter_input(INPUT_GET, 'add_cart', FILTER_VALIDATE_INT);

// Determine the page to return to.
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$refererHost = parse_url($referer, PHP_URL_HOST);
$currentHost = $_SERVER['HTTP_HOST'] ?? '';

if (
    $referer !== '' &&
    $refererHost !== null &&
    $refererHost === parse_url('http://' . $currentHost, PHP_URL_HOST)
) {
    $redirectUrl = $referer;
} else {
    $redirectUrl = "../index.php";
}

// Validate the product ID.
if (!$product_id || $product_id < 1) {
    $_SESSION['cart_message'] = "Invalid product selected.";

    header("Location: " . $redirectUrl);
    exit;
}

// If the visitor is not logged in, show a message
// and return to the same page.
if (!is_logged_in()) {
    $_SESSION['cart_message'] =
        "Please log in or register to add products to your cart.";

    header("Location: " . $redirectUrl);
    exit;
}

// Continue with cart operations for logged-in visitors.
$cartController = new CartController();
$ip = get_ip();

// Check whether the product is already in the cart.
if ($cartController->isInCart($product_id, $ip)) {
    $_SESSION['cart_message'] =
        "This item is already in your cart. Go to cart to update quantity.";

    header("Location: " . $redirectUrl);
    exit;
}

// Add the product to the cart.
$added = $cartController->addToCart($product_id, 1, $ip);

if ($added) {
    $_SESSION['cart_message'] = "Product added to your cart.";
} else {
    $_SESSION['cart_message'] =
        "Unable to add this product to your cart.";
}

header("Location: " . $redirectUrl);
exit;
