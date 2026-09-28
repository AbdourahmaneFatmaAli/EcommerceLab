<?php

// This page is only for logged-in customers.
require_once "../core/core.php";

require_login();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account</title>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<h1>My Account</h1>

<ul>
    <li>
        <strong>Name:</strong>
        <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
    </li>

    <li>
        <strong>Email:</strong>
        <?php echo htmlspecialchars($_SESSION['customer_email']); ?>
    </li>
</ul>
<?php require_once __DIR__ . "/layout/footer.php"; ?>