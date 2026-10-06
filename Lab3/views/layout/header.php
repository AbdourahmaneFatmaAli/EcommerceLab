<?php

?>

<style>

    .site-nav {
        background: white;
        padding: 18px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-bottom: 1px solid #f3d4e3;
        box-shadow: 0 3px 15px rgba(214, 51, 132, 0.08);
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .nav-link {
        color: #8f1d55;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        padding: 9px 14px;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        background: #fff0f6;
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
        color: white;
        background: #d63384;
        padding: 9px 17px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .nav-logout:hover {
        background: #a61e62;
        transform: translateY(-1px);
    }

    @media (max-width: 700px) {

        .site-nav {
            padding: 15px;
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

    }

</style>

<nav class="site-nav">

    <div class="nav-left">

        <a
            href="/Ecommerce-class/index.php"
            class="nav-link"
        >
            Home
        </a>

        <?php if (is_logged_in()) { ?>

            <span class="nav-divider">|</span>

            <span class="nav-welcome">
                Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
            </span>

            <span class="nav-divider">|</span>

            <a
                href="/Ecommerce-class/views/my_account.php"
                class="nav-link"
            >
                My Account
            </a>

            <?php if (is_admin()) { ?>

                <span class="nav-divider">|</span>

                <a
                    href="/Ecommerce-class/views/admin/brand.php"
                    class="nav-link"
                >
                    Brand
                </a>

                <span class="nav-divider">|</span>

                <a
                    href="/Ecommerce-class/views/admin/category.php"
                    class="nav-link"
                >
                    Category
                </a>

            <?php } ?>

        <?php } else { ?>

            <span class="nav-divider">|</span>

            <a
                href="/Ecommerce-class/views/register.php"
                class="nav-link"
            >
                Register
            </a>

            <span class="nav-divider">|</span>

            <a
                href="/Ecommerce-class/views/login.php"
                class="nav-link"
            >
                Login
            </a>

        <?php } ?>

    </div>

    <?php if (is_logged_in()) { ?>

        <a
            href="/Ecommerce-class/logout.php"
            class="nav-logout"
        >
            Logout
        </a>

    <?php } ?>

</nav>