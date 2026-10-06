<?php

require_once "../core/core.php";
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/admin/category.php");
    exit;
}

require_once "../controllers/ProductController.php";

$cat_id = $_POST['cat_id'] ?? '';
$name = strip_tags(trim($_POST['cat_name'] ?? ''));
$brand_id = $_POST['brand_id'] ?? '';

if (!filter_var($cat_id, FILTER_VALIDATE_INT) || (int) $cat_id <= 0) {
    $_SESSION['error'] = "Invalid category.";
    header("Location: ../views/admin/category.php");
    exit;
}

if ($name === '') {
    $_SESSION['error'] = "Category name is required.";
    header("Location: ../views/admin/category.php?edit_id=" . (int) $cat_id);
    exit;
}

if (!filter_var($brand_id, FILTER_VALIDATE_INT) || (int) $brand_id <= 0) {
    $_SESSION['error'] = "Please select a brand.";
    header("Location: ../views/admin/category.php?edit_id=" . (int) $cat_id);
    exit;
}

$cat_id = (int) $cat_id;
$brand_id = (int) $brand_id;

$controller = new ProductController();

$existingCategory = $controller->getCategoryById($cat_id);

if (!$existingCategory) {
    $_SESSION['error'] = "Category not found.";
    header("Location: ../views/admin/category.php");
    exit;
}

if ($controller->categoryExists($name, $brand_id)) {

    if (
        (int) $existingCategory['cat_id'] !== $cat_id
    ) {
        $_SESSION['error'] = "This category already exists for this brand.";
        header("Location: ../views/admin/category.php?edit_id=" . $cat_id);
        exit;
    }
}

$result = $controller->updateCategory(
    $cat_id,
    $name,
    $brand_id
);

if ($result) {
    $_SESSION['success'] = "Category updated.";
} else {
    $_SESSION['error'] = "Failed to update category.";
}

header("Location: ../views/admin/category.php");
exit;