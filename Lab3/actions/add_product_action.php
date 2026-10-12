<?php

require_once "../core/core.php";
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/admin/product.php");
    exit;
}

require_once "../controllers/ProductController.php";

$cat = $_POST['product_cat'] ?? '';
$brand = $_POST['product_brand'] ?? '';
$title = strip_tags(trim($_POST['product_title'] ?? ''));
$price = $_POST['product_price'] ?? '';
$desc = trim($_POST['product_desc'] ?? '');
$keywords = trim($_POST['product_keywords'] ?? '');

if (
    !filter_var($cat, FILTER_VALIDATE_INT) ||
    (int) $cat <= 0 ||
    !filter_var($brand, FILTER_VALIDATE_INT) ||
    (int) $brand <= 0
) {
    $_SESSION['error'] = "Please select a valid category and brand.";
    header("Location: ../views/admin/product.php");
    exit;
}

if ($title === '' || strlen($title) > 200) {
    $_SESSION['error'] = "Please enter a valid product title.";
    header("Location: ../views/admin/product.php");
    exit;
}

if (!is_numeric($price) || (float) $price < 0) {
    $_SESSION['error'] = "Please enter a valid product price.";
    header("Location: ../views/admin/product.php");
    exit;
}

if (strlen($desc) > 500 || strlen($keywords) > 100) {
    $_SESSION['error'] = "Description or keywords are too long.";
    header("Location: ../views/admin/product.php");
    exit;
}

if (
    !isset($_FILES['product_image']) ||
    $_FILES['product_image']['error'] !== UPLOAD_ERR_OK
) {
    $_SESSION['error'] = "Please select a product image.";
    header("Location: ../views/admin/product.php");
    exit;
}

$image = $_FILES['product_image'];
$maxSize = 2 * 1024 * 1024;

if ($image['size'] > $maxSize) {
    $_SESSION['error'] = "Image size must not exceed 2 MB.";
    header("Location: ../views/admin/product.php");
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
    $_SESSION['error'] = "Only JPG, PNG, GIF, and WebP images are allowed.";
    header("Location: ../views/admin/product.php");
    exit;
}

$filename = uniqid('product_', true) . '.' . $allowed[$mime];
$uploadPath = __DIR__ . '/../images/products/';

if (!is_dir($uploadPath)) {
    $_SESSION['error'] = "Product image folder was not found.";
    header("Location: ../views/admin/product.php");
    exit;
}

if (!move_uploaded_file($image['tmp_name'], $uploadPath . $filename)) {
    $_SESSION['error'] = "Image upload failed. Please try again.";
    header("Location: ../views/admin/product.php");
    exit;
}

$controller = new ProductController();

$result = $controller->addProduct(
    (int) $cat,
    (int) $brand,
    $title,
    (float) $price,
    $desc,
    $filename,
    $keywords
);

if ($result) {
    $_SESSION['success'] = "Product added successfully.";
} else {
    unlink($uploadPath . $filename);
    $_SESSION['error'] = "This same product with same other things already exists, you cannot add it.";
}

header("Location: ../views/admin/product.php");
exit;
