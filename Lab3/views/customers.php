<?php

require_once "../core/core.php";
require_once "../functions/customer_functions.php";

$customers = getAllCustomersList();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Customers</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<main>

    <h1>All Customers</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Country</th>
                <th>City</th>
                <th>Contact</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($customers as $customer) { ?>

                <tr>
                    <td><?php echo htmlspecialchars($customer['customer_id']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_email']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_country']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_city']); ?></td>
                    <td><?php echo htmlspecialchars($customer['customer_contact']); ?></td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

</main>

<?php require_once __DIR__ . "/layout/footer.php"; ?>