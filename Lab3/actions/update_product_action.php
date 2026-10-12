
<?php

require_once "../core/core.php";
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/admin/product.php");
    exit;
}

require_once "../controllers/ProductController.php";

$id = $_POST['product_id'] ?? '';
$cat = $_POST['product_cat'] ?? '';
$brand = $_POST['product_brand'] ?? '';
$title = strip_tags(trim($_POST['product_title'] ?? ''));
$price = $_POST['product_price'] ?? '';
$desc = trim($_POST['product_desc'] ?? '');
$keywords = trim($_POST['product_keywords'] ?? '');

if (!filter_var($id, FILTER_VALIDATE_INT) || (int) $id <= 0) {
    $_SESSION['error'] = "Invalid product.";
    header("Location: ../views/admin/product.php");
    exit;
}

$id = (int) $id;
$controller = new ProductController();
$existingProduct = $controller->getProductById($id);

if (!$existingProduct) {
    $_SESSION['error'] = "Product not found.";
    header("Location: ../views/admin/product.php");
    exit;
}

$oldFilename = $existingProduct['product_image'] ?? '';

if (
    !filter_var($cat, FILTER_VALIDATE_INT) ||
    (int) $cat <= 0 ||
    !filter_var($brand, FILTER_VALIDATE_INT) ||
    (int) $brand <= 0
) {
    $_SESSION['error'] = "Please select a valid category and brand.";
    header("Location: ../views/admin/product.php?edit_id=" . $id);
    exit;
}

if ($title === '' || strlen($title) > 200) {
    $_SESSION['error'] = "Please enter a valid product title.";
    header("Location: ../views/admin/product.php?edit_id=" . $id);
    exit;
}

if (!is_numeric($price) || (float) $price < 0) {
    $_SESSION['error'] = "Please enter a valid product price.";
    header("Location: ../views/admin/product.php?edit_id=" . $id);
    exit;
}

if (strlen($desc) > 500 || strlen($keywords) > 100) {
    $_SESSION['error'] = "Description or keywords are too long.";
    header("Location: ../views/admin/product.php?edit_id=" . $id);
    exit;
}

$filename = $oldFilename;
$uploadPath = __DIR__ . '/../images/products/';

if (
    isset($_FILES['product_image']) &&
    $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $image = $_FILES['product_image'];

    if ($image['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Image upload failed.";
        header("Location: ../views/admin/product.php?edit_id=" . $id);
        exit;
    }

    if ($image['size'] > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Image size must not exceed 2 MB.";
        header("Location: ../views/admin/product.php?edit_id=" . $id);
        exit;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($image['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];

    if (!isset($allowed[$mime])) {
        $_SESSION['error'] =
            "Only JPG, PNG, GIF, and WebP images are allowed.";
        header("Location: ../views/admin/product.php?edit_id=" . $id);
        exit;
    }

    $newFilename = uniqid('product_', true) . '.' . $allowed[$mime];

    if (!move_uploaded_file($image['tmp_name'], $uploadPath . $newFilename)) {
        $_SESSION['error'] = "Could not save the new image.";
        header("Location: ../views/admin/product.php?edit_id=" . $id);
        exit;
    }

    $filename = $newFilename;
}

// Check for a duplicate before attempting the update.
if ($controller->productDuplicateExists(
    $id,
    (int) $cat,
    (int) $brand,
    $title,
    (float) $price,
    $desc,
    $filename,
    $keywords
)) {
    if ($filename !== $oldFilename && is_file($uploadPath . $filename)) {
        unlink($uploadPath . $filename);
    }

    $_SESSION['error'] =
        "This product already exists with the same details and image.";

    header("Location: ../views/admin/product.php?edit_id=" . $id);
    exit;
}

$result = $controller->updateProduct(
    $id,
    (int) $cat,
    (int) $brand,
    $title,
    (float) $price,
    $desc,
    $filename,
    $keywords
);

if ($result) {
    if ($filename !== $oldFilename && $oldFilename !== '') {
        $oldPath = $uploadPath . basename($oldFilename);

        if (is_file($oldPath)) {
            unlink($oldPath);
        }
    }

    $_SESSION['success'] = "Product updated successfully.";
    header("Location: ../views/admin/product.php");
    exit;
}

if ($filename !== $oldFilename && is_file($uploadPath . $filename)) {
    unlink($uploadPath . $filename);
}

$_SESSION['error'] = "Failed to update the product. Please try again.";
header("Location: ../views/admin/product.php?edit_id=" . $id);
exit;
