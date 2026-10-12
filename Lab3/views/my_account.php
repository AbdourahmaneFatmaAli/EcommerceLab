<?php

require_once __DIR__ . "/../core/core.php";

require_login();

$isAdmin = is_admin();

$customerName = htmlspecialchars(
    $_SESSION['customer_name'] ?? 'Customer',
    ENT_QUOTES,
    'UTF-8'
);

$customerEmail = htmlspecialchars(
    $_SESSION['customer_email'] ?? '',
    ENT_QUOTES,
    'UTF-8'
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $isAdmin ? "Admin Dashboard" : "My Account"; ?>
    </title>

    <style>

        .account-page {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 25px 50px;
        }

        .account-hero {
            position: relative;
            overflow: hidden;
            border-radius: 26px;
            padding: 45px 50px;
            margin-bottom: 42px;
            color: white;
            box-shadow: 0 15px 35px rgba(214, 51, 132, 0.2);
            min-height: 260px;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }

        .customer-hero {
            background: linear-gradient(135deg, #d63384, #e85d9f, #f783b8);
        }

        .admin-hero {
            background: linear-gradient(135deg, #941650, #d63384, #ed6aa7);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 650px;
        }

        .account-badge {
            display: block;
            margin-bottom: 12px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
        }

        .account-hero h1 {
            margin: 0 0 12px;
            font-size: 38px;
            line-height: 1.2;
        }

        .account-hero p {
            margin: 0 0 25px;
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.92;
        }

        .hero-details {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            font-size: 13px;
        }

        .hero-detail {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .hero-detail-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            opacity: 0.7;
        }

        .hero-detail-value {
            font-weight: 600;
        }

        .hero-heart {
            position: absolute;
            right: 35px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 230px;
            line-height: 1;
            color: white;
            opacity: 0.13;
            z-index: 1;
            pointer-events: none;
        }

        .section-heading {
            margin-bottom: 22px;
        }

        .section-heading h2 {
            margin: 0 0 6px;
            color: #8f1d55;
            font-size: 25px;
        }

        .section-heading p {
            margin: 0;
            color: #777;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .dashboard-card {
            position: relative;
            min-height: 145px;
            padding: 28px;
            background: white;
            border: 1px solid #f3d4e3;
            border-radius: 20px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 7px 20px rgba(214, 51, 132, 0.07);
            transition: all 0.25s ease;
            overflow: hidden;
            box-sizing: border-box;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
            border-color: #e8a5c4;
            box-shadow: 0 15px 30px rgba(214, 51, 132, 0.14);
        }

        .dashboard-card h3 {
            margin: 0 0 10px;
            color: #a61e62;
            font-size: 21px;
        }

        .dashboard-card p {
            margin: 0;
            color: #777;
            font-size: 14px;
            line-height: 1.6;
        }

        .link-card {
            display: block;
            cursor: pointer;
        }

        .link-label {
            display: inline-block;
            margin-top: 18px;
            padding: 7px 14px;
            border-radius: 20px;
            background: #fff0f6;
            color: #c02670;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .dashboard-card:hover .link-label {
            background: #d63384;
            color: white;
        }

        .coming-soon-card {
            cursor: default;
        }

        .coming-soon-card:hover {
            transform: none;
            border-color: #f3d4e3;
            box-shadow: 0 7px 20px rgba(214, 51, 132, 0.07);
        }

        .coming-soon {
            display: inline-block;
            margin-top: 18px;
            padding: 6px 12px;
            border-radius: 20px;
            background: #fff0f6;
            color: #d63384;
            font-size: 11px;
            font-weight: bold;
        }

        @media (max-width: 750px) {

            .account-page {
                margin-top: 25px;
                padding: 0 15px 35px;
            }

            .account-hero {
                padding: 32px 27px;
                border-radius: 20px;
                min-height: auto;
            }

            .account-hero h1 {
                font-size: 29px;
            }

            .hero-heart {
                right: -15px;
                font-size: 150px;
            }

            .hero-details {
                gap: 18px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<main class="account-page">

    <?php if ($isAdmin): ?>

        <section class="account-hero admin-hero">

            <div class="hero-content">

                <span class="account-badge">ADMIN</span>

                <h1>
                    Welcome back, <?php echo $customerName; ?>!
                </h1>

                <p>
                    Manage your store and keep everything organized from one place.
                </p>

                <div class="hero-details">

                    <div class="hero-detail">
                        <span class="hero-detail-label">Email</span>
                        <span class="hero-detail-value">
                            <?php echo $customerEmail; ?>
                        </span>
                    </div>

                    <div class="hero-detail">
                        <span class="hero-detail-label">Account Type</span>
                        <span class="hero-detail-value">Administrator</span>
                    </div>

                </div>

            </div>

            <div class="hero-heart">♡</div>

        </section>

        <section class="dashboard-section">

            <div class="section-heading">
                <h2>Store Management</h2>
                <p>Quick access to the main areas of your store.</p>
            </div>

            <div class="dashboard-grid">

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/admin/brand.php"
                    class="dashboard-card link-card"
                >
                    <h3>Brands</h3>
                    <p>Add and manage the brands available in your store.</p>
                    <span class="link-label">Manage Brands</span>
                </a>

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/admin/category.php"
                    class="dashboard-card link-card"
                >
                    <h3>Categories</h3>
                    <p>Organize your products into different categories.</p>
                    <span class="link-label">Manage Categories</span>
                </a>

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/admin/product.php"
                    class="dashboard-card link-card"
                >
                    <h3>Products</h3>
                    <p>Add, edit, and manage the products available in your store.</p>
                    <span class="link-label">Manage Products</span>
                </a>

                <div class="dashboard-card coming-soon-card">
                    <h3>Customers</h3>
                    <p>View and manage your store customers.</p>
                    <span class="coming-soon">Coming soon</span>
                </div>

            </div>

        </section>

    <?php else: ?>

        <section class="account-hero customer-hero">

            <div class="hero-content">

                <span class="account-badge">MY ACCOUNT</span>

                <h1>
                    Welcome back, <?php echo $customerName; ?>!
                </h1>

                <div class="hero-details">

                    <div class="hero-detail">
                        <span class="hero-detail-label">Email</span>
                        <span class="hero-detail-value">
                            <?php echo $customerEmail; ?>
                        </span>
                    </div>

                    <div class="hero-detail">
                        <span class="hero-detail-label">Account Type</span>
                        <span class="hero-detail-value">Customer</span>
                    </div>

                </div>

            </div>

            <div class="hero-heart">♡</div>

        </section>

        <section class="dashboard-section">

            <div class="section-heading">
                <h2>Your Account</h2>
                <p>Manage your account and explore your store activities.</p>
            </div>

            <div class="dashboard-grid">

                <a
                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/index.php"
                    class="dashboard-card link-card"
                >
                    <h3>Browse Products</h3>
                    <p>
                        Explore the products available in our store and find something you like.
                    </p>
                    <span class="link-label">Start Shopping</span>
                </a>

                <div class="dashboard-card">
                    <h3>My Profile</h3>
                    <p>View your personal account information.</p>
                </div>

                <div class="dashboard-card coming-soon-card">
                    <h3>My Orders</h3>
                    <p>Your orders will appear here.</p>
                    <span class="coming-soon">Coming soon</span>
                </div>

                <div class="dashboard-card coming-soon-card">
                    <h3>Favorites</h3>
                    <p>Save products you love for later.</p>
                    <span class="coming-soon">Coming soon</span>
                </div>

                <div class="dashboard-card coming-soon-card">
                    <h3>Account Settings</h3>
                    <p>Manage your account preferences.</p>
                    <span class="coming-soon">Coming soon</span>
                </div>

            </div>

        </section>

    <?php endif; ?>

</main>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>

</html>

