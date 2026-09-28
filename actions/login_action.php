<?php

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/login.php");
    exit;
}

// Load core and controller
require_once "../core/core.php";
require_once "../controllers/CustomerController.php";

// Clean normal text input
function cleanInput($value)
{
    return strip_tags(trim($value));
}

// Get and sanitise form values
$email = cleanInput($_POST['customer_email'] ?? '');
$pass = $_POST['customer_pass'] ?? '';

// Check required fields
if ($email === '' || $pass === '') {
    $_SESSION['error'] = "Email and password are required.";
    header("Location: ../views/login.php");
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please enter a valid email address.";
    header("Location: ../views/login.php");
    exit;
}

// Create controller
$controller = new CustomerController();

// Try to log in
$customer = $controller->login($email, $pass);

// Check the result
if (isset($customer['success']) && $customer['success'] === false) {

    $_SESSION['error'] = $customer['error'];

    header("Location: ../views/login.php");
    exit;
}

// Login successful
$_SESSION['customer_id'] = $customer['customer_id'];
$_SESSION['customer_name'] = $customer['customer_name'];
$_SESSION['customer_email'] = $customer['customer_email'];
$_SESSION['user_role'] = $customer['user_role'];

// Redirect to home page
header("Location: ../index.php");
exit;