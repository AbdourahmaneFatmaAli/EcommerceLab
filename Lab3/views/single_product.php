
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/ProductController.php";

if (
    !isset($_GET['pro_id']) ||
    filter_var($_GET['pro_id'], FILTER_VALIDATE_INT) === false ||
    (int) $_GET['pro_id'] <= 0
) {
    header("Location: home.php");
    exit;
}

$productId = (int) $_GET['pro_id'];

$controller = new ProductController();
$product = $controller->getProductById($productId);

if (!$product) {
    header("Location: home.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($product['product_title']); ?></title>

    <link rel="stylesheet" href="/Ecommerce-class/Lab3/css/style.css">

    <style>
        .single-product {
            display: flex;
            gap: 35px;
            align-items: flex-start;
            max-width: 1000px;
            margin: 40px auto;
            padding: 25px;
            background: white;
            border: 1px solid #f3d4e3;
            border-radius: 16px;
            box-shadow: 0 3px 15px rgba(214, 51, 132, 0.08);
        }

        .single-product-image {
            flex: 1;
            min-width: 0;
        }

        .single-product-image img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
        }

        .single-product-info {
            flex: 1;
            min-width: 0;
        }

        .single-product-info h1 {
            color: #8f1d55;
        }

        .single-product-price {
            color: #d63384;
            font-size: 24px;
            font-weight: bold;
        }

        .single-product-info p {
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .add-cart-link {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background: #d63384;
            color: white;
            text-decoration: none;
            border-radius: 9px;
        }

        .add-cart-link:hover {
            background: #a61e62;
        }

        @media (max-width: 700px) {
            .single-product {
                flex-direction: column;
                margin: 20px 15px;
            }

            .single-product-image,
            .single-product-info {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<main class="single-product">

    <div class="single-product-image">

        <?php if (!empty($product['product_image'])): ?>

            <img
                src="/Ecommerce-class/Lab3/images/products/<?php echo rawurlencode(basename($product['product_image'])); ?>"
                alt="<?php echo htmlspecialchars($product['product_title']); ?>"
            >

        <?php else: ?>

            <p>No image available for this product.</p>

        <?php endif; ?>

    </div>

    <div class="single-product-info">

        <h1><?php echo htmlspecialchars($product['product_title']); ?></h1>

        <p>
            <strong>Category:</strong>
            <?php echo htmlspecialchars($product['cat_name']); ?>
        </p>

        <p>
            <strong>Brand:</strong>
            <?php echo htmlspecialchars($product['brand_name']); ?>
        </p>

        <p class="single-product-price">
            GHS <?php echo number_format((float) $product['product_price'], 2); ?>
        </p>

        <p>
            <strong>Description:</strong><br>
            <?php
            echo nl2br(
                htmlspecialchars($product['product_desc'] ?? 'No description available.')
            );
            ?>
        </p>

        <p>
            <strong>Keywords:</strong>
            <?php echo htmlspecialchars($product['product_keywords'] ?? 'None'); ?>
        </p>

        <a
            class="add-cart-link"
            href="home.php?add_cart=<?php echo (int) $product['product_id']; ?>"
        >
            Add to Cart
        </a>

        <p>
            <a href="home.php">← Back to Products</a>
        </p>

    </div>

</main>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>
