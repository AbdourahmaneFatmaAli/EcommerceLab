<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/register.php");
    exit;
}


require_once "../core/core.php";
require_once "../controllers/CustomerController.php";


function cleanInput($value)
{
    return strip_tags(trim($value));
}


$name = cleanInput($_POST['customer_name'] ?? '');
$email = cleanInput($_POST['customer_email'] ?? '');
$pass = $_POST['customer_pass'] ?? '';
$country = cleanInput($_POST['customer_country'] ?? '');
$city = cleanInput($_POST['customer_city'] ?? '');
$contact = cleanInput($_POST['customer_contact'] ?? '');


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
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $pass)) {
    $_SESSION['error'] = "Password must be at least 8 characters and contain an uppercase letter, lowercase letter, number, and special character.";
    header("Location: ../views/register.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please enter a valid email address.";
    header("Location: ../views/register.php");
    exit;
}


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


$controller = new CustomerController();


$data = [
    'name' => $name,
    'email' => $email,
    'pass' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact
];


$result = $controller->register($data);


if ($result['success']) {


    header("Location: ../views/login.php");
    exit;

} else {

    $_SESSION['error'] = $result['error'];

    header("Location: ../views/register.php");
    exit;
}

