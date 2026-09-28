<?php

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/register.php");
    exit;
}

// Load core and controller
require_once "../core/core.php";
require_once "../controllers/CustomerController.php";

// Clean user input
function cleanInput($value)
{
    return strip_tags(trim($value));
}

// Get and sanitise form inputs
$name = cleanInput($_POST['customer_name'] ?? '');
$email = cleanInput($_POST['customer_email'] ?? '');
$pass = $_POST['customer_pass'] ?? '';
$country = cleanInput($_POST['customer_country'] ?? '');
$city = cleanInput($_POST['customer_city'] ?? '');
$contact = cleanInput($_POST['customer_contact'] ?? '');

// Check required fields
if (
    $name === '' ||
    $email === '' ||
    $pass === '' ||
    $country === '' ||
    $city === '' ||
    $contact === ''
) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../views/register.php");
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please enter a valid email address.";
    header("Location: ../views/register.php");
    exit;
}

// Validate field lengths against database schema
if (
    strlen($name) > 100 ||
    strlen($email) > 100 ||
    strlen($country) > 100 ||
    strlen($city) > 100 ||
    strlen($contact) > 20
) {
    $_SESSION['error'] = "One or more fields exceed the allowed length.";
    header("Location: ../views/register.php");
    exit;
}

// Create controller
$controller = new CustomerController();

// Prepare registration data
$data = [
    'name' => $name,
    'email' => $email,
    'pass' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact
];

// Register customer
$result = $controller->register($data);

// Handle result
if ($result['success']) {

    $customer = $controller->login($email, $pass);

    if ($customer) {
        $_SESSION['customer_id'] = $customer['customer_id'];
        $_SESSION['customer_name'] = $customer['customer_name'];
        $_SESSION['customer_email'] = $customer['customer_email'];
        $_SESSION['user_role'] = $customer['user_role'];
    }

    header("Location: ../views/my_account.php");
    exit;

} else {

    $_SESSION['error'] = $result['error'];

    header("Location: ../views/register.php");
    exit;
}