
<?php

require_once __DIR__ . "/../../core/core.php";
require_once __DIR__ . "/../../controllers/CartController.php";

$cartCount = 0;
$cartTotal = 0.0;

if (is_logged_in()) {
    $cartController = new CartController();
    $cartIp = get_ip();

    $cartCount = $cartController->getCartCount($cartIp);
    $cartTotal = $cartController->getCartTotal($cartIp);
}

$currentPage = basename($_SERVER['PHP_SELF'] ?? '');

?>

<style>
    .site-nav {
        background: rgba(255, 255, 255, 0.72);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        padding: 18px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-bottom: 1px solid rgba(243, 212, 227, 0.7);
        box-shadow: 0 5px 25px rgba(214, 51, 132, 0.06);
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        min-width: 0;
    }

    .nav-link {
        color: #8f1d55;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        padding: 9px 14px;
        border-radius: 10px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .nav-link:hover {
        background: rgba(255, 240, 246, 0.8);
        color: #d63384;
    }

    .nav-welcome {
        color: #777;
        font-size: 14px;
        padding: 0 5px;
    }

    .nav-divider {
        color: #e8a5c4;
        font-size: 14px;
    }

    .nav-logout {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #8f1d55;
        background: rgba(255, 255, 255, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.8);
        padding: 10px 17px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.2s ease;
    }

    .nav-logout:hover {
        background: rgba(255, 240, 246, 0.9);
        color: #a61e62;
    }

    .nav-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 14px;
        flex-wrap: wrap;
    }

    /* Frosted-glass shopping cart */
    .cart-summary {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 15px;
        background: rgba(255, 255, 255, 0.42);
        color: #542b42;
        border: 1px solid rgba(255, 255, 255, 0.85);
        border-radius: 18px;
        box-shadow:
            0 8px 30px rgba(100, 50, 75, 0.07),
            inset 0 1px 0 rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(24px) saturate(180%);
        -webkit-backdrop-filter: blur(24px) saturate(180%);
    }

    .cart-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 13px;
        font-size: 21px;
    }

    .cart-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .cart-title {
        font-size: 13px;
        font-weight: 700;
        color: #542b42;
    }

    .cart-details {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        font-size: 12px;
        color: #856779;
    }

    .cart-count {
        color: #542b42;
        font-weight: 600;
    }

    .cart-separator {
        color: #c3a8b8;
    }

    .cart-total {
        font-size: 13px;
        font-weight: 700;
        color: #542b42;
        white-space: nowrap;
    }

    .cart-button,
    .cart-button:link,
    .cart-button:visited {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        margin-left: 5px;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.48);
        color: #8f1d55;
        border: 1px solid rgba(255, 255, 255, 0.85);
        border-radius: 12px;
        text-decoration: none !important;
        box-shadow: 0 3px 12px rgba(100, 50, 75, 0.04);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .cart-button:hover,
    .cart-button:focus,
    .cart-button:active {
        background: rgba(255, 255, 255, 0.8);
        color: #8f1d55;
        text-decoration: none !important;
        outline: none;
    }

    .cart-message {
        margin: 15px 30px;
        padding: 12px 16px;
        border: 1px solid rgba(243, 212, 227, 0.8);
        border-radius: 12px;
        background: rgba(255, 240, 246, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        color: #8f1d55;
        font-size: 14px;
    }

    @media (max-width: 900px) {
        .site-nav {
            align-items: flex-start;
            flex-direction: column;
            padding: 15px 20px;
        }

        .nav-right {
            width: 100%;
            justify-content: flex-start;
        }
    }

    @media (max-width: 700px) {
        .site-nav {
            padding: 15px 12px;
            gap: 14px;
        }

        .nav-left {
            gap: 4px;
        }

        .nav-link {
            font-size: 13px;
            padding: 7px 9px;
        }

        .nav-welcome {
            display: none;
        }

        .nav-right {
            align-items: flex-start;
            gap: 10px;
        }

        .cart-summary {
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
            max-width: 100%;
            box-sizing: border-box;
        }

        .cart-button {
            margin-left: 0;
        }

        .cart-details {
            gap: 5px;
        }

        .nav-logout {
            padding: 9px 13px;
        }

        .cart-message {
            margin: 12px;
        }
    }
</style>

<nav class="site-nav">

    <div class="nav-left">

        <a
            href="/~fatma.abdourahmane/Ecommerce-class/Lab3/index.php"
            class="nav-link"
        >Home</a>

        <?php if (is_logged_in()) { ?>

            <span class="nav-divider">|</span>

            <span class="nav-welcome">
                Welcome,
                <?php
                echo htmlspecialchars(
                    $_SESSION['customer_name'] ?? 'Customer',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </span>

            <span class="nav-divider">|</span>

            <a
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/my_account.php"
                class="nav-link"
            >My Account</a>

            <?php if (is_admin()) { ?>

                <span class="nav-divider">|</span>

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/admin/brand.php"
                    class="nav-link"
                >Brand</a>

                <span class="nav-divider">|</span>

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/admin/category.php"
                    class="nav-link"
                >Category</a>

                <span class="nav-divider">|</span>

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/admin/product.php"
                    class="nav-link"
                >Product</a>

            <?php } ?>

        <?php } else { ?>

            <span class="nav-divider">|</span>

            <a
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/register.php"
                class="nav-link"
            >Register</a>

            <span class="nav-divider">|</span>

            <a
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/login.php"
                class="nav-link"
            >Login</a>

        <?php } ?>

    </div>

    <div class="nav-right">

        <?php if (is_logged_in()) { ?>

            <div class="cart-summary">

                <div class="cart-icon" aria-hidden="true">🛒</div>

                <div class="cart-info">

                    <span class="cart-title">Shopping Cart</span>

                    <span class="cart-details">

                        <span class="cart-count">
                            <?php echo (int) $cartCount; ?>
                            <?php echo ((int) $cartCount === 1) ? 'item' : 'items'; ?>
                        </span>

                        <span class="cart-separator">·</span>

                        <span class="cart-total">
                            GHS <?php echo number_format((float) $cartTotal, 2); ?>
                        </span>

                    </span>

                </div>

                <?php if ($currentPage !== 'cart.php') { ?>
                    <a
                        href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/cart.php"
                        class="cart-button"
                    >View Cart</a>
                <?php } ?>

            </div>

            <a
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/logout.php"
                class="nav-logout"
            >Logout</a>

        <?php } ?>

    </div>

</nav>

<?php if (!empty($_SESSION['cart_message'])) { ?>

    <p class="cart-message">
        <?php
        echo htmlspecialchars(
            $_SESSION['cart_message'],
            ENT_QUOTES,
            'UTF-8'
        );

        unset($_SESSION['cart_message']);
        ?>
    </p>

<?php } ?>
