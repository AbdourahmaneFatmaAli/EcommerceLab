
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CartController.php";

$cartController = new CartController();
$ip = get_ip();

$cartItems = $cartController->getCartItems($ip);
$cartTotal = $cartController->getCartTotal($ip);

$cartMessage = $_SESSION['cart_message'] ?? '';
unset($_SESSION['cart_message']);

require_once __DIR__ . "/layout/header.php";
?>

<style>
.cart-container {
    max-width: 1100px;
    margin: 35px auto;
    padding: 25px;
    background: rgba(255, 255, 255, 0.38);
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 24px;
    box-shadow:
        0 12px 40px rgba(100, 50, 75, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    box-sizing: border-box;
}

.cart-container h1 {
    color: #8f1d55;
    margin-bottom: 20px;
}

.cart-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: rgba(255, 255, 255, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.75);
    border-radius: 14px;
    overflow: hidden;
}

.cart-table th,
.cart-table td {
    border-right: 1px solid rgba(240, 213, 226, 0.65);
    border-bottom: 1px solid rgba(240, 213, 226, 0.65);
    padding: 12px;
    text-align: left;
}

.cart-table th:last-child,
.cart-table td:last-child {
    border-right: none;
}

.cart-table tbody tr:last-child td {
    border-bottom: none;
}

.cart-table th {
    background: rgba(255, 240, 246, 0.65);
    color: #8f1d55;
}

.cart-table td {
    color: #542b42;
    background: rgba(255, 255, 255, 0.18);
}

.cart-image {
    width: 75px;
    height: 75px;
    object-fit: contain;
}

.cart-qty {
    width: 75px;
    padding: 7px;
    border: 1px solid #e8c6d7;
    border-radius: 7px;
    background: rgba(255, 255, 255, 0.8);
    color: #542b42;
}

.cart-actions {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.cart-actions form {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
}

.cart-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    min-height: 40px;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    background: #d63384;
    color: #ffffff;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    transition: background 0.2s ease;
}

.cart-button:hover {
    background: #a61e62;
    color: #ffffff;
}
.cart-container a.cart-button,
.cart-container a.cart-button:link,
.cart-container a.cart-button:visited {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    min-height: 40px;
    padding: 10px 16px;
    background: #d63384 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 8px;
    text-decoration: none !important;
    cursor: pointer;
    font-size: 14px !important;
    font-weight: 600 !important;
    font-family: inherit;
    white-space: nowrap;
    margin: 0;
}

.cart-container a.cart-button:hover {
    background: #a61e62 !important;
    color: #ffffff !important;
}
.cart-container a.continue-shopping,
.cart-container a.continue-shopping:link,
.cart-container a.continue-shopping:visited,
.cart-container a.continue-shopping:hover,
.cart-container a.continue-shopping:focus,
.cart-container a.continue-shopping:active {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    min-height: 40px;
    padding: 10px 16px;
    background: #d63384 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 8px;
    text-decoration: none !important;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    margin: 0;
    transition: background 0.2s ease;
}

.cart-container a.continue-shopping:hover,
.cart-container a.continue-shopping:focus {
    background: #a61e62 !important;
    color: #ffffff !important;
}

.cart-message {
    padding: 12px;
    margin-bottom: 18px;
    background: rgba(255, 240, 246, 0.75);
    color: #8f1d55;
    border: 1px solid rgba(243, 212, 227, 0.8);
    border-radius: 10px;
}

.cart-empty {
    padding: 25px;
    background: rgba(255, 255, 255, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 16px;
    color: #542b42;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

.cart-subtotal {
    text-align: right;
    color: #8f1d55;
    font-size: 20px;
    font-weight: bold;
    margin-top: 20px;
}

.cart-product-name {
    margin-top: 5px;
    color: #542b42;
}

@media (max-width: 700px) {
    .cart-container {
        margin: 20px 12px;
        padding: 15px;
    }

    .cart-table {
        font-size: 12px;
    }

    .cart-table th,
    .cart-table td {
        padding: 7px;
    }

    .cart-image {
        width: 50px;
        height: 50px;
    }

    .cart-qty {
        width: 55px;
    }

    .cart-subtotal {
        font-size: 18px;
    }

    .cart-actions {
        gap: 8px;
    }

    .cart-actions .cart-button,
    .cart-actions a.continue-shopping {
        min-height: 38px;
        padding: 9px 12px;
        font-size: 13px;
    }
}
</style>

<div class="cart-container">
    <h1>Shopping Cart</h1>

    <?php if ($cartMessage !== '') { ?>
        <div class="cart-message">
            <?php
            echo htmlspecialchars(
                $cartMessage,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>
        </div>
    <?php } ?>

    <?php if (empty($cartItems)) { ?>

        <div class="cart-empty">
            <p>Your cart is empty. Browse our products to get started.</p>

            <a
                class="continue-shopping"
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/index.php"
            >Continue Shopping</a>
        </div>

    <?php } else { ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Remove</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($cartItems as $item) { ?>
                    <?php
                    $productId = (int) $item['p_id'];
                    $productTitle = (string) ($item['product_title'] ?? '');
                    $imageFile = basename($item['product_image'] ?? '');
                    $imagePath = "/~fatma.abdourahmane/Ecommerce-class/Lab3/images/products/"
                        . rawurlencode($imageFile);
                    $quantity = (int) $item['qty'];
                    $price = (float) $item['product_price'];
                    ?>

                    <tr>
                        <td>
                            <input
                                type="checkbox"
                                name="remove[]"
                                value="<?php echo $productId; ?>"
                                form="removeCartForm"
                                aria-label="Remove <?php
                                    echo htmlspecialchars(
                                        $productTitle,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                ?>"
                            >
                        </td>

                        <td>
                            <?php if ($imageFile !== '') { ?>
                                <img
                                    class="cart-image"
                                    src="<?php
                                        echo htmlspecialchars(
                                            $imagePath,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                    alt="<?php
                                        echo htmlspecialchars(
                                            $productTitle,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>"
                                >
                            <?php } ?>

                            <div class="cart-product-name">
                                <?php
                                echo htmlspecialchars(
                                    $productTitle,
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </div>
                        </td>

                        <td>
                            <input
                                class="cart-qty"
                                type="number"
                                name="qty[<?php echo $productId; ?>]"
                                value="<?php echo $quantity; ?>"
                                min="1"
                                required
                                form="updateCartForm"
                            >

                            <input
                                type="hidden"
                                name="update[]"
                                value="<?php echo $productId; ?>"
                                form="updateCartForm"
                            >
                        </td>

                        <td>
                            $<?php echo number_format($price, 2); ?>
                        </td>

                        <td>
                            $<?php echo number_format($quantity * $price, 2); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="cart-subtotal">
            Total: $<?php echo number_format((float) $cartTotal, 2); ?>
        </div>

        <div class="cart-actions">
            <form
                id="removeCartForm"
                method="POST"
                action="../actions/remove_from_cart_action.php"
            >
                <button class="cart-button" type="submit">
                    Remove from Cart
                </button>
            </form>

            <form
                id="updateCartForm"
                method="POST"
                action="../actions/update_qty_action.php"
            >
                <button class="cart-button" type="submit">
                    Update Quantity
                </button>
            </form>

            <a
                class="continue-shopping"
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/index.php"
            >Continue Shopping</a>
            <a
                class="cart-button"
                href="payment.php"
            >Proceed to Payment</a>
        </div>
        

    <?php } ?>
</div>

<?php require_once __DIR__ . "/layout/footer.php"; ?>
