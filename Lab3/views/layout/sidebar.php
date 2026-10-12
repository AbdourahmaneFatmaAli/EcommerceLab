
<?php

require_once __DIR__ . "/../../controllers/ProductController.php";

$sidebarController = new ProductController();

$sidebarCategories = $sidebarController->getAllCategories();
$sidebarBrands = $sidebarController->getAllBrands();

?>

<style>
    .shop-sidebar {
        width: 220px;
        flex-shrink: 0;
        padding: 22px;
        background: #fff7fb;
        border: 1px solid #f4d7e6;
        border-radius: 16px;
        box-shadow: 0 4px 14px rgba(180, 60, 120, 0.06);
    }

    .shop-sidebar h3 {
        margin: 0 0 14px;
        color: #8f1d55;
        font-size: 18px;
        font-weight: 700;
    }

    .shop-sidebar ul {
        list-style: none;
        margin: 0 0 25px;
        padding: 0;
    }

    .shop-sidebar li {
        margin-bottom: 7px;
    }

    .shop-sidebar a {
        display: block;
        padding: 10px 12px;
        border-radius: 9px;
        color: #55404b;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .shop-sidebar a:hover {
        background: #f9dce9;
        color: #8f1d55;
    }

    .shop-sidebar .all-products-link {
        background: #d63384;
        color: white;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .shop-sidebar .all-products-link:hover {
        background: #a61e62;
        color: white;
    }

    .shop-sidebar .sidebar-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
    }

    @media (max-width: 700px) {
        .shop-sidebar {
            width: auto;
            box-sizing: border-box;
            align-self: stretch;
        }
    }
</style>

<aside class="shop-sidebar">

    <div class="sidebar-heading">
        <h3>Categories</h3>
    </div>

    <ul>
        <li>
            <a
                class="all-products-link"
                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/"
            >
                All Products
            </a>
        </li>

        <?php foreach ($sidebarCategories as $category): ?>
            <li>
                <a href="/~fatma.abdourahmane/Ecommerce-class/Lab3/?cat=<?php echo (int) $category['cat_id']; ?>">
                    <?php echo htmlspecialchars($category['cat_name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="sidebar-heading">
        <h3>Brands</h3>
    </div>

    <ul>
        <?php foreach ($sidebarBrands as $brand): ?>
            <li>
                <a href="/~fatma.abdourahmane/Ecommerce-class/Lab3/?brand=<?php echo (int) $brand['brand_id']; ?>">
                    <?php echo htmlspecialchars($brand['brand_name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</aside>
