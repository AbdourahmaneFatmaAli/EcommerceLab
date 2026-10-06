<?php

// Load core first
require_once "../core/core.php";

// Only admins can update brands
require_admin();

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/admin/brand.php");
    exit;
}

// Load the controller
require_once "../controllers/ProductController.php";

// Get the brand ID
$id = $_POST['brand_id'] ?? '';

// Validate that the ID is a positive integer
if (filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id <= 0) {
    $_SESSION['error'] = "Invalid brand ID.";
    header("Location: ../views/admin/brand.php");
    exit;
}

$id = (int) $id;

// Get and sanitise the brand name
$name = strip_tags(trim($_POST['brand_name'] ?? ''));

// Validate brand name
if ($name === '') {
    $_SESSION['error'] = "Brand name is required.";
    header("Location: ../views/admin/brand.php?edit_id=" . $id);
    exit;
}

// Create controller
$controller = new ProductController();

// Update the brand
$result = $controller->updateBrand($id, $name);

// Handle result
if ($result) {
    $_SESSION['success'] = "Brand updated.";
} else {
    $_SESSION['error'] = "Failed to update brand.";
}

// Return to the brand page
header("Location: ../views/admin/brand.php");
exit;