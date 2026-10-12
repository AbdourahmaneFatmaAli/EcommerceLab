<?php

require_once "../core/core.php";
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/admin/category.php");
    exit;
}

require_once "../controllers/ProductController.php";

$name = strip_tags(trim($_POST['cat_name'] ?? ''));
$brand_id = $_POST['brand_id'] ?? '';

if ($name === '') {
    $_SESSION['error'] = "Category name is required.";
    header("Location: ../views/admin/category.php");
    exit;
}

if (!filter_var($brand_id, FILTER_VALIDATE_INT) || (int) $brand_id <= 0) {
    $_SESSION['error'] = "Please select a brand.";
    header("Location: ../views/admin/category.php");
    exit;
}

$brand_id = (int) $brand_id;

$controller = new ProductController();

if ($controller->categoryExists($name, $brand_id)) {
    $_SESSION['error'] = "This category already exists for this brand.";
    header("Location: ../views/admin/category.php");
    exit;
}

$result = $controller->addCategory($name, $brand_id);

if ($result) {
    $_SESSION['success'] = "Category added.";
} else {
    $_SESSION['error'] = "Failed to add category.";
}

header("Location: ../views/admin/category.php");
exit;
