
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/ProductController.php";

$controller = new ProductController();

$query = trim($_GET['user_query'] ?? '');
$products = [];

if ($query !== '') {
    $products = $controller->searchProducts($query);
}

if (!is_array($products)) {
    $products = [];
}

$baseUrl = "/~fatma.abdourahmane/Ecommerce-class/Lab3";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Search Results - Ecom LAB</title>

    <link
        rel="stylesheet"
        href="<?php echo $baseUrl; ?>/css/style.css"
    >

    <style>
        .search-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 25px;
        }

        .search-heading {
            color: #8f1d55;
            margin-bottom: 10px;
        }

        .search-description {
            color: #666;
            margin-bottom: 25px;
        }

        .search-query {
            color: #d63384;
            font-weight: 600;
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 22px;
            margin-top: 25px;
        }

        .search-card {
            background: white;
            border: 1px solid #f3d4e3;
            border-radius: 14px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(214, 51, 132, 0.06);
        }

        .search-card img {
            width: 100%;
            height: 190px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .search-card h3 {
            color: #8f1d55;
            font-size: 17px;
            margin: 10px 0;
        }

        .search-price {
            font-weight: bold;
            margin: 12px 0;
        }

        .details-button,
        .back-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 9px;
            background: #d63384;
            color: white;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .details-button:hover,
        .back-button:hover {
            background: #a61e62;
        }

        .search-empty {
            padding: 25px;
            background: #fff0f6;
            border: 1px solid #f3d4e3;
            border-radius: 12px;
            color: #71334f;
            margin: 25px 0;
        }

        .back-link {
            margin-top: 25px;
        }

        @media (max-width: 700px) {
            .search-page {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>

    <?php require_once __DIR__ . "/layout/header.php"; ?>

    <main class="search-page">

        <h1 class="search-heading">Search Results</h1>

        <p class="search-description">
            Results for:
            <span class="search-query">
                <?php echo htmlspecialchars($query); ?>
            </span>
        </p>

        <?php if ($query === ''): ?>

            <div class="search-empty">
                Please enter a product name or keyword to search.
            </div>

        <?php elseif (empty($products)): ?>

            <div class="search-empty">
                No products found. Try another product name or keyword.
            </div>

        <?php else: ?>

            <div class="search-grid">

                <?php foreach ($products as $product): ?>

                    <article class="search-card">

                        <?php if (!empty($product['product_image'])): ?>

                            <img
                                src="<?php echo $baseUrl; ?>/images/products/<?php echo rawurlencode(basename($product['product_image'])); ?>"
                                alt="<?php echo htmlspecialchars($product['product_title']); ?>"
                            >

                        <?php else: ?>

                            <p>No image available</p>

                        <?php endif; ?>

                        <h3>
                            <?php echo htmlspecialchars($product['product_title']); ?>
                        </h3>

                        <p class="search-price">
                            GHS
                            <?php echo number_format((float) $product['product_price'], 2); ?>
                        </p>

                        <a
                            class="details-button"
                            href="<?php echo $baseUrl; ?>/views/single_product.php?pro_id=<?php echo (int) $product['product_id']; ?>"
                        >
                            View Details
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <div class="back-link">
            <a
                class="back-button"
                href="<?php echo $baseUrl; ?>/index.php"
            >
                ← Back to Products
            </a>
        </div>

    </main>

    <?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>
