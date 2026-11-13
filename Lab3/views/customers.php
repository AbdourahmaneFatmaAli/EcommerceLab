
<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controllers/CustomerController.php";

require_login();

if (!is_admin()) {
    http_response_code(403);
    exit("Access denied.");
}

$customerController = new CustomerController();
$customers = $customerController->selectAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers</title>

    <style>
        .customers-page {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px 50px;
        }

        .customers-page h1 {
            color: #a61e62;
        }

        .customers-card {
            background: white;
            border: 1px solid #f3d4e3;
            border-radius: 15px;
            padding: 25px;
            margin-top: 25px;
            box-shadow: 0 7px 20px rgba(214, 51, 132, 0.07);
            overflow-x: auto;
        }

        .customers-table {
            width: 100%;
            border-collapse: collapse;
        }

        .customers-table th,
        .customers-table td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .customers-table th {
            color: #a61e62;
            background: #fff0f6;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #d63384;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        .empty-message {
            background: #fff0f6;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<main class="customers-page">

    <h1>Customers</h1>
    <p>View and manage your store customers.</p>

    <a href="my_account.php" class="back-link">
        Back to Dashboard
    </a>

    <div class="customers-card">

        <?php if (empty($customers)): ?>

            <div class="empty-message">
                <h2>No customers found</h2>
                <p>Registered customers will appear here.</p>
            </div>

        <?php else: ?>

            <table class="customers-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Contact</th>
                        <th>Role</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo (int) $customer['customer_id']; ?></td>
                            <td><?php echo htmlspecialchars($customer['customer_name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($customer['customer_email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($customer['customer_country'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($customer['customer_city'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($customer['customer_contact'] ?? ''); ?></td>
                            <td>
                                <?php echo (int) $customer['user_role'] === 1 ? 'Admin' : 'Customer'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

    </div>

</main>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>
