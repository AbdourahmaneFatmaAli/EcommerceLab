<?php

require_once "../../core/core.php";
require_admin();

require_once "../../controllers/ProductController.php";

$controller = new ProductController();

$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
$products = $controller->getAllProducts();

$editId = $_GET['edit_id'] ?? '';
$editProduct = null;

if ($editId !== '') {
    if (filter_var($editId, FILTER_VALIDATE_INT) !== false && (int) $editId > 0) {
        $editId = (int) $editId;
        $editProduct = $controller->getProductById($editId);

        if (!$editProduct) {
            $_SESSION['error'] = "Product not found.";
            header("Location: product.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Invalid product.";
        header("Location: product.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $editProduct ? "Edit Product" : "Manage Products"; ?></title>

    <link rel="stylesheet" href="/~fatma.abdourahmane/Ecommerce-class/Lab3/css/style.css">
</head>

<body>

<?php require_once __DIR__ . "/../layout/header.php"; ?>

<main>

    <h1>Manage Products</h1>

    <?php
    if (!empty($_SESSION['success'])) {
        echo '<p class="success-message">'
            . htmlspecialchars($_SESSION['success'])
            . '</p>';

        unset($_SESSION['success']);
    }

    if (!empty($_SESSION['error'])) {
        echo '<p class="error-message" style="
            border: none !important;
            border-left: none !important;
            box-shadow: none !important;
        ">'
            . htmlspecialchars($_SESSION['error'])
            . '</p>';

        unset($_SESSION['error']);
    }
    ?>

    <h2><?php echo $editProduct ? "Edit Product" : "Add Product"; ?></h2>

    <form
        action="<?php echo $editProduct
            ? '../../actions/update_product_action.php'
            : '../../actions/add_product_action.php'; ?>"
        method="POST"
        enctype="multipart/form-data"
        id="productForm"
    >

        <?php if ($editProduct): ?>

            <input
                type="hidden"
                name="product_id"
                value="<?php echo (int) $editProduct['product_id']; ?>"
            >

            <input
                type="hidden"
                name="existing_image"
                value="<?php echo htmlspecialchars($editProduct['product_image'] ?? ''); ?>"
            >

        <?php endif; ?>

        <div>
            <label for="product_title">Product Title</label>

            <input
                type="text"
                name="product_title"
                id="product_title"
                maxlength="200"
                value="<?php echo htmlspecialchars($editProduct['product_title'] ?? ''); ?>"
                required
            >
        </div>

        <div>
            <label for="product_price">Price</label>

            <input
                type="number"
                name="product_price"
                id="product_price"
                min="0"
                step="0.01"
                value="<?php echo htmlspecialchars((string) ($editProduct['product_price'] ?? '')); ?>"
                required
            >
        </div>

        <div>
            <label for="product_desc">Description</label>

            <textarea
                name="product_desc"
                id="product_desc"
                maxlength="500"
                rows="4"
            ><?php echo htmlspecialchars($editProduct['product_desc'] ?? ''); ?></textarea>
        </div>

        <div>
            <label for="product_keywords">Keywords</label>

            <input
                type="text"
                name="product_keywords"
                id="product_keywords"
                maxlength="100"
                value="<?php echo htmlspecialchars($editProduct['product_keywords'] ?? ''); ?>"
            >
        </div>

        <div>
            <label for="product_cat">Category</label>

            <select name="product_cat" id="product_cat" required>
                <option value="">Select Category</option>

                <?php foreach ($categories as $category): ?>
                    <option
                        value="<?php echo (int) $category['cat_id']; ?>"
                        <?php
                        echo $editProduct &&
                            (int) $category['cat_id'] === (int) $editProduct['product_cat']
                            ? 'selected'
                            : '';
                        ?>
                    >
                        <?php echo htmlspecialchars($category['cat_name']); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div>
            <label for="product_brand">Brand</label>

            <select name="product_brand" id="product_brand" required>
                <option value="">Select Brand</option>

                <?php foreach ($brands as $brand): ?>
                    <option
                        value="<?php echo (int) $brand['brand_id']; ?>"
                        <?php
                        echo $editProduct &&
                            (int) $brand['brand_id'] === (int) $editProduct['product_brand']
                            ? 'selected'
                            : '';
                        ?>
                    >
                        <?php echo htmlspecialchars($brand['brand_name']); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <?php if ($editProduct && !empty($editProduct['product_image'])): ?>

            <div>
                <p>Current Image</p>

                <img
                    src="../../images/products/<?php echo rawurlencode(basename($editProduct['product_image'])); ?>"
                    alt="Current product image"
                    style="max-width: 180px; max-height: 180px; object-fit: contain;"
                >
            </div>

        <?php endif; ?>

        <div>
            <label for="product_image">
                <?php echo $editProduct ? "Choose a New Image (Optional)" : "Product Image"; ?>
            </label>

            <input
                type="file"
                name="product_image"
                id="product_image"
                accept="image/jpeg,image/png,image/gif,image/webp"
                <?php echo $editProduct ? '' : 'required'; ?>
            >

            <p>Allowed formats: JPG, PNG, GIF, WebP. Maximum size: 2 MB.</p>

            <p id="imageError" class="error-message" role="alert"></p>

            <img
                id="imagePreview"
                alt="Selected image preview"
                style="display:none; max-width:180px; max-height:180px; object-fit:contain;"
            >
        </div>

        <div>
            <button type="submit">
                <?php echo $editProduct ? "Update Product" : "Add Product"; ?>
            </button>

            <?php if ($editProduct): ?>
                <a href="product.php">Cancel</a>
            <?php endif; ?>
        </div>

    </form>

    <h2>Existing Products</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php if (!empty($products)): ?>

            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo (int) $product['product_id']; ?></td>

                    <td>
                        <?php if (!empty($product['product_image'])): ?>
                            <img
                                src="../../images/products/<?php echo rawurlencode(basename($product['product_image'])); ?>"
                                alt="Product image"
                                style="max-width:70px; max-height:70px; object-fit:contain;"
                            >
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>

                    <td><?php echo htmlspecialchars($product['product_title']); ?></td>

                    <td><?php echo htmlspecialchars($product['brand_name']); ?></td>

                    <td><?php echo htmlspecialchars($product['cat_name']); ?></td>

                    <td><?php echo htmlspecialchars((string) $product['product_price']); ?></td>

                    <td>
                        <a href="product.php?edit_id=<?php echo (int) $product['product_id']; ?>">
                            Edit
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="7">No products found.</td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</main>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>

<script>
const productForm = document.getElementById('productForm');
const imageInput = document.getElementById('product_image');
const imageError = document.getElementById('imageError');
const imagePreview = document.getElementById('imagePreview');

const allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp'
];

const maxSize = 2 * 1024 * 1024;

imageInput.addEventListener('change', function () {
    imageError.textContent = '';
    imagePreview.style.display = 'none';
    imagePreview.removeAttribute('src');

    const file = this.files[0];

    if (!file) {
        return;
    }

    if (!allowedTypes.includes(file.type)) {
        imageError.textContent = 'Choose a JPG, PNG, GIF, or WebP image.';
        this.value = '';
        return;
    }

    if (file.size > maxSize) {
        imageError.textContent = 'Image size must not exceed 2 MB.';
        this.value = '';
        return;
    }

    imagePreview.src = URL.createObjectURL(file);
    imagePreview.style.display = 'block';
});

productForm.addEventListener('submit', function (event) {
    const file = imageInput.files[0];

    if (!file) {
        <?php if (!$editProduct): ?>
        imageError.textContent = 'Please select a product image.';
        event.preventDefault();
        <?php endif; ?>
        return;
    }

    if (!allowedTypes.includes(file.type) || file.size > maxSize) {
        imageError.textContent = 'Select an allowed image that is no larger than 2 MB.';
        event.preventDefault();
    }
});
</script>

</body>
</html>