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

    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="stylesheet" href="/~fatma.abdourahmane/Ecommerce-class/Lab3/css/style.css">

    <style>
        .shop-layout {
            display: flex;
            align-items: flex-start;
            gap: 25px;
            padding: 25px;
            max-width: 1450px;
            margin: 0 auto;
        }
        .shop-content {
    flex: 1;
    min-width: 0;
    max-width: none;
    margin: 0;
    padding: 0;
    background: transparent;
    border: none;
    border-radius: 0;
    box-shadow: none;
}

        .shop-content {
            flex: 1;
            min-width: 0;
        }

        .shop-content h1 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        /* Product search */
        .product-search {
            display: flex;
            align-items: stretch;
            gap: 10px;
            margin: 20px 0 28px;
            max-width: 550px;
            padding: 0;
            background: transparent;
            border: none;
            border-radius: 0;
            box-shadow: none;
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
            white-space: nowrap;
        }

        .product-search button:hover {
            background: #a61e62;
        }

        /* Product grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(210px, 1fr)
            );
            gap: 22px;
            align-items: stretch;
        }

        /* Individual product card */
        .product-card {
            border: 1px solid #f3d4e3;
            border-radius: 14px;
            padding: 16px;
            background: white;
            text-align: center;
            box-shadow: 0 3px 12px rgba(214, 51, 132, 0.06);
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
            transition: transform 0.2s ease,
                        box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 18px rgba(214, 51, 132, 0.12);
        }

        /* Show the entire product image */
        .product-card img {
            display: block;
            width: 100%;
            height: 200px;
            object-fit: contain;
            object-position: center;
            margin: 0 auto 12px;
        }

        .product-card h3 {
            color: #8f1d55;
            font-size: 17px;
            line-height: 1.4;
            margin: 8px 0;
            overflow-wrap: anywhere;
        }

        .product-price {
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        /* Keep both buttons aligned */
        .product-actions {
    display: flex;
    align-items: stretch;
    gap: 8px;
    margin-top: auto;
    padding-top: 12px;
    width: 100%;
}

.product-actions a {
    flex: 1;
    min-width: 0;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 5px;
    border: 1px solid #d63384;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    line-height: 1.3;
    overflow-wrap: anywhere;
    transition: background 0.2s ease, color 0.2s ease;
}

/* Details button */
.product-actions a:first-child {
    background: #fce4ef;
    color: #b02a6b;
}

.product-actions a:first-child:hover {
    background: #f5c5dc;
    color: #8f1d55;
}

/* Add to Cart button */
.product-actions a:last-child {
    background: #d63384;
    color: white;
}

.product-actions a:last-child:hover {
    background: #a61e62;
}



        .no-products {
            padding: 25px;
            background: #fff0f6;
            border: 1px solid #f3d4e3;
            border-radius: 12px;
        }

        /* Responsive layout */
        @media (max-width: 900px) {
            .shop-layout {
                gap: 18px;
                padding: 20px;
            }

            .product-grid {
                grid-template-columns: repeat(
                    auto-fit,
                    minmax(190px, 1fr)
                );
                gap: 16px;
            }
        }

        @media (max-width: 700px) {
            .shop-layout {
                flex-direction: column;
                padding: 15px;
            }

            .shop-content {
                width: 100%;
            }

            .product-search {
                max-width: 100%;
            }

            .product-grid {
                grid-template-columns: repeat(
                    auto-fit,
                    minmax(160px, 1fr)
                );
                gap: 14px;
            }

            .product-card {
                padding: 12px;
            }

            .product-card img {
                height: 170px;
            }

            .product-actions {
                flex-direction: column;
            }

            .product-actions a {
                width: 100%;
                min-height: 38px;
            }
        }

        @media (max-width: 380px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .product-card img {
                height: 210px;
            }

            .product-actions {
                flex-direction: row;
            }
        }
    </style>
</head>

<body>

    <?php require_once __DIR__ . "/layout/header.php"; ?>

    <div class="shop-layout">

        <?php require_once __DIR__ . "/layout/sidebar.php"; ?>

        <main class="shop-content">

            <h1><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></h1>

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
                            ? htmlspecialchars($_GET['user_query'], ENT_QUOTES, 'UTF-8')
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

                        <?php
                        $productId = (int) ($product['product_id'] ?? 0);
                        $productTitle = $product['product_title'] ?? 'Untitled Product';
                        $productPrice = (float) ($product['product_price'] ?? 0);
                        $productImage = $product['product_image'] ?? '';
                        ?>

                        <div class="product-card">

                            <?php if (!empty($productImage)): ?>

                                <img
                                    src="/~fatma.abdourahmane/Ecommerce-class/Lab3/images/products/<?php echo rawurlencode(basename($productImage)); ?>"
                                    alt="<?php echo htmlspecialchars($productTitle, ENT_QUOTES, 'UTF-8'); ?>"
                                    loading="lazy"
                                >

                            <?php else: ?>

                                <p>No image available</p>

                            <?php endif; ?>

                            <h3>
                                <?php echo htmlspecialchars($productTitle, ENT_QUOTES, 'UTF-8'); ?>
                            </h3>

                            <p class="product-price">
                                GHS <?php echo number_format($productPrice, 2); ?>
                            </p>

                            <div class="product-actions">

                                <a
                                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/views/single_product.php?pro_id=<?php echo $productId; ?>"
                                >Details</a>

                                <a
                                    href="/~fatma.abdourahmane/Ecommerce-class/Lab3/actions/add_to_cart_action.php?add_cart=<?php echo $productId; ?>"
                                >Add to Cart</a>

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
