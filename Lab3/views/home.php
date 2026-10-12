
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/ProductController.php";

$controller = new ProductController();

$products = [];
$pageTitle = "Our Products";

if (isset($_GET['cat'])) {

    $catId = filter_var($_GET['cat'], FILTER_VALIDATE_INT);

    if ($catId !== false && $catId > 0) {
        $products = $controller->getProductsByCategory($catId);
        $pageTitle = "Products by Category";
    }

} elseif (isset($_GET['brand'])) {

    $brandId = filter_var($_GET['brand'], FILTER_VALIDATE_INT);

    if ($brandId !== false && $brandId > 0) {
        $products = $controller->getProductsByBrand($brandId);
        $pageTitle = "Products by Brand";
    }

} else {

    $products = $controller->getFeaturedProducts();
}

if (!is_array($products)) {
    $products = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <link rel="stylesheet" href="/~fatma.abdourahmane/Ecommerce-class/Lab3/css/style.css">

    <style>
        .shop-layout {
            display: flex;
            align-items: flex-start;
            gap: 25px;
            padding: 25px;
        }

        .shop-content {
            flex: 1;
            min-width: 0;
        }

        .product-search {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            max-width: 500px;
        }

        .product-search input {
            flex: 1;
            min-width: 0;
            padding: 12px;
            border: 1px solid #e8b8d0;
            border-radius: 8px;
            font-size: 15px;
        }

        .product-search button {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            background: #d63384;
            color: white;
            cursor: pointer;
        }

        .product-search button:hover {
            background: #a61e62;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 22px;
        }

        .product-card {
            border: 1px solid #f3d4e3;
            border-radius: 14px;
            padding: 15px;
            background: white;
            text-align: center;
            box-shadow: 0 3px 12px rgba(214, 51, 132, 0.06);
        }

        .product-card img {
            width: 100%;
            height: 190px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .product-card h3 {
            color: #8f1d55;
            font-size: 17px;
        }

        .product-price {
            font-weight: bold;
            margin: 12px 0;
        }

        .product-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .product-actions a {
            display: inline-block;
            padding: 9px 12px;
            border-radius: 8px;
            text-decoration: none;
            background: #d63384;
            color: white;
            font-size: 14px;
        }

        .product-actions a:hover {
            background: #a61e62;
        }

        .no-products {
            padding: 25px;
            background: #fff0f6;
            border-radius: 12px;
        }

        @media (max-width: 700px) {
            .shop-layout {
                flex-direction: column;
                padding: 15px;
            }

            .shop-content {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<div class="shop-layout">

    <?php require_once __DIR__ . "/layout/sidebar.php"; ?>

    <main class="shop-content">

        <h1><?php echo htmlspecialchars($pageTitle); ?></h1>

        <!-- Product search form -->
        <form
            action="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/search_results.php"
            method="GET"
            class="product-search"
        >
            <input
                type="text"
                name="user_query"
                placeholder="Search for a product..."
                aria-label="Search for a product"
                value="<?php
                    echo isset($_GET['user_query'])
                        ? htmlspecialchars($_GET['user_query'])
                        : '';
                ?>"
                required
            >

            <button type="submit">Search</button>
        </form>

        <!-- Product list -->
        <?php if (empty($products)): ?>

            <p class="no-products">
                No products found. Please check back later.
            </p>

        <?php else: ?>

            <div class="product-grid">

                <?php foreach ($products as $product): ?>

                    <div class="product-card">

                        <?php if (!empty($product['product_image'])): ?>

                            <img
                                src="/~fatma.abdourahmane/Ecommerce-class/Lab3/images/products/<?php echo rawurlencode(basename($product['product_image'])); ?>"
                                alt="<?php echo htmlspecialchars($product['product_title']); ?>"
                            >

                        <?php else: ?>

                            <p>No image available</p>

                        <?php endif; ?>

                        <h3>
                            <?php echo htmlspecialchars($product['product_title']); ?>
                        </h3>

                        <p class="product-price">
                            GHS
                            <?php
                            echo number_format(
                                (float) $product['product_price'],
                                2
                            );
                            ?>
                        </p>

                        <div class="product-actions">

                            <a
                                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/single_product.php?pro_id=<?php echo (int) $product['product_id']; ?>"
                            >
                                Details
                            </a>

                            <a
                                href="/~fatma.abdourahmane/Ecommerce-class/Lab3/index.php?add_cart=<?php echo (int) $product['product_id']; ?>"
                            >
                                Add to Cart
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </main>

</div>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>
