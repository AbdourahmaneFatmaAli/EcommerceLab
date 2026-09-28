<?php

require_once "../core/core.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Customer</title>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<h1>Customer Registration</h1>

<?php
if (isset($_SESSION['error'])) {
    echo "<p>" . htmlspecialchars($_SESSION['error']) . "</p>";
    unset($_SESSION['error']);
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Customer</title>

    <link rel="stylesheet" href="/ecomlab/css/style.css">
</head>

<form action="../actions/register_action.php" method="POST" enctype="multipart/form-data">

    <div>
        <label for="customer_name">Full Name</label>
        <input
            type="text"
            name="customer_name"
            id="customer_name"
            required
        >
    </div>

    <div>
        <label for="customer_email">Email</label>
        <input
            type="email"
            name="customer_email"
            id="customer_email"
            required
        >
    </div>

    <div>
        <label for="customer_pass">Password</label>
        <input
            type="password"
            name="customer_pass"
            id="customer_pass"
            required
        >
    </div>

    <div>
        <label for="customer_country">Country</label>
        <select
            name="customer_country"
            id="customer_country"
            required
        >
            <option value="">Select Country</option>
            <option value="Ghana">Ghana</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Benin">Benin</option>
            <option value="Togo">Togo</option>
            <option value="Burkina Faso">Burkina Faso</option>
            <option value="Mali">Mali</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div>
        <label for="customer_city">City</label>
        <input
            type="text"
            name="customer_city"
            id="customer_city"
            required
        >
    </div>

    <div>
        <label for="customer_contact">Contact Number</label>
        <input
            type="text"
            name="customer_contact"
            id="customer_contact"
            required
        >
    </div>

    <div>
        <label for="customer_address">Address</label>
        <input
            type="text"
            name="customer_address"
            id="customer_address"
            required
        >
    </div>

    <div>
        <label for="customer_image">Image (optional)</label>
        <input
            type="file"
            name="customer_image"
            id="customer_image"
            accept="image/*"
        >
    </div>

    <div>
        <button type="submit">Register</button>
    </div>

</form>

<script src="../js/validate.js"></script>

<?php require_once __DIR__ . "/layout/footer.php"; ?>