<?php


require_once "../core/core.php";

// Only admins can add brands
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/admin/brand.php");
    exit;
}

// Load the controller
require_once "../controllers/ProductController.php";

// Get and sanitise the brand name
$name = strip_tags(trim($_POST['brand_name'] ?? ''));

if ($name === '') {
    $_SESSION['error'] = "Brand name is required.";
    header("Location: ../views/admin/brand.php");
    exit;
}

// Create controller
$controller = new ProductController();

// Check if brand already exists
if ($controller->brandExists($name)) {
    $_SESSION['error'] = "This brand already exists you cannot add it.";
    header("Location: ../views/admin/brand.php");
    exit;
}


$result = $controller->addBrand($name);


if ($result) {
    $_SESSION['success'] = "Brand added.";
} else {
    $_SESSION['error'] = "Failed to add brand.";
}

// Return to the brand page
header("Location: ../views/admin/brand.php");
exit;
